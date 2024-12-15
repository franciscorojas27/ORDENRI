<?php

namespace App\Http\Controllers\Order;

use App\Models\Type;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Models\Resolution_Area;
use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatusNotification;

class OrderController extends Controller
{
    /**
     * Muestra una lista de órdenes filtradas según el rol del usuario autenticado.
     * Dependiendo del tipo de usuario (Administrador, Cliente o cualquier otro rol),
     * la consulta se ajusta para mostrar las órdenes correspondientes.
     * 
     * @param Request $request La solicitud HTTP que contiene los filtros de búsqueda.
     * @var \App\Models\User $user El usuario autenticado.
     * @return \Illuminate\View\View La vista que muestra las órdenes filtradas.     * 
     */
    public function index(Request $request)
    {
        $user = User::find(Auth::id());
        $query = Order::with('applicantTo', 'type', 'resolutionArea', 'status')
            ->where('is_deleted', 'false');

        if ($user->isClient()) {
            $query = Auth::user()->group
                ? $query->whereHas('client', function ($query) {
                    $query->where('coordination_management', Auth::user()->coordination_management);
                })
                : $query->where('client_id', Auth::id());
        } elseif ($user->isAdmin()) {
            $query->where('resolution_area_id', '!=', null);
        }

        $message = $this->applyFilters($request, $query);
        if ($query->count() == 0) {
            session()->flash('message', $this->getEmptyOrdersMessage($request));
        } else {
            session()->flash('message', $message);
        }
        return view('order.index', [
            'orders' => $query->orderBy('id', 'desc')->paginate(30),
            'types' => Type::all(),
            'resolution_areas' => Resolution_Area::all(),
            'statuses' => Status::all(),
            'getRedirectRoute' => fn($order) => $this->getRedirectRouteToShow($order),
        ]);
    }
    /**
     * Muestra el formulario para crear una nueva orden.
     * 
     * @return \Illuminate\View\View La vista que muestra el formulario para crear una orden.
     */
    public function create()
    {
        return view('order.create', ['types' => Type::all(), 'resolution_areas' => Resolution_Area::all()]);
    }
    /**
     * Crea una nueva orden con los datos enviados en la solicitud HTTP.
     * La orden se crea con un estado de "Enviado" y se notifica a los
     * responsables de la dependencia correspondiente.
     * 
     * @param  \App\Http\Requests\StoreOrderRequest  $request La solicitud HTTP que contiene los datos de la orden.
     * @return \Illuminate\Http\RedirectResponse La respuesta HTTP que redirige al usuario a la lista de órdenes.
     */
    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'client_id' => $request->input('user_id'),
            'resolution_area_id' => $request->input('resolution_areas'),
            'type_id' => $request->input('types'),
            'client_description' => $request->description,
            'status_id' => 1
        ]);
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $originalName = $file->getClientOriginalName();
                $file->storeAs('orders', $file->hashName(), 'local');
                $order->files()->create([
                    'original_name' => $originalName,
                    'file_name' => $file->hashName(),
                    'file_path' => $file->storeAs('orders', $file->hashName(), 'local'),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        Notification::send(
            User::where('resolution_area_id', $order->resolution_area_id)->get(),
            new OrderStatusNotification($order)
        );

        return redirect()->route('order.index');
    }
    /**
     * Muestra los detalles de una orden específica.
     *
     * Carga los archivos asociados a la orden dada y pasa los datos necesarios
     * a la vista 'order.show'.
     *
     * @param Order $order La orden a mostrar.
     * @return \Illuminate\View\View La vista que muestra los detalles de la orden.
     */
    public function show(Order $order)
    {
        return view('order.show', [
            'order' => $order->load('files'),
            'redirectRoute' => $this->getRedirectRouteToIndex(),
        ]);
    }
    /**
     * Muestra el formulario de edición para una orden específica.
     * Carga los archivos asociados a la orden y pasa los datos necesarios a la vista.
     *
     * @param Order $order La orden que se va a editar.
     * @return \Illuminate\View\View La vista del formulario de edición de la orden.
     */
    public function edit(Order $order)
    {
        $order->load('files');
        return view('order.edit', [
            'statuses' => Status::all(),
            'types' => Type::all(),
            'resolutionAreas' => Resolution_Area::all(),
            'order' => $order,
            'supervisors' => User::getEmployeesByJobTitle($order->resolution_area_id, 'Supervisor'),
            'applicantToList' => User::getEmployeesByJobTitle($order->resolution_area_id, ['Supervisor', 'Analista'])
        ]);
    }
    /**
     * Actualiza una orden especifica en la base de datos.
     *
     * Lanza el evento OrderStatusUpdated y actualiza los campos de la orden con los datos
     * proporcionados en la solicitud.
     *
     * @param \App\Http\Requests\UpdateOrderRequest $request La solicitud HTTP con los datos a actualizar.
     * @param \App\Models\Order $order La orden que se va a actualizar.
     * @return \Illuminate\Http\Response La respuesta HTTP con la redirección a la vista de edición de la orden.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        event(new OrderStatusUpdated($order));
        $order->update($request->updateFields());
        return redirect()->route('order.edit', $order);
    }
    /**
     * Elimina una orden especifica de la base de datos.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */

    public function destroy(Order $order)
    {
        $order->update([
            'is_deleted' => true,
            'delete_by_user_id' => Auth::id(),
        ]);
        return redirect()->route('order.index');
    }
    /**
     * Actualiza el estado de una orden en función de su estado actual y agrega una descripción.
     *
     * Si el estado actual es 1 (Pendiente), se establece el estado en 2 (En curso), se agrega la fecha de inicio y se establece el usuario actual como responsable.
     * Si el estado actual es 2 (En curso), se establece el estado en 3 (Finalizada), se agrega la fecha de finalización y se mantiene el responsable actual.
     * Luego, se lanza el evento OrderStatusUpdated y se actualiza la orden en la base de datos.
     * Finalmente, se redirige a la vista de índice de órdenes.
     *
     * @param  \App\Models\Order  $order La orden que se va a actualizar.
     * @param  \Illuminate\Http\Request  $request La solicitud HTTP con la descripción de la orden.
     * @return \Illuminate\Http\Response La respuesta HTTP con la redirección a la vista de índice de órdenes.
     */
    public function orderFlow(Order $order, Request $request)
    {
        $request->validate([
            'description' => 'required|min:10|max:500',
        ]);
        $updateData = ['description' => $request->description];
        switch ($order->status_id) {
            case 1:
                $updateData['status_id'] = 2;
                $updateData['start_at'] = now();
                $updateData['applicant_to_id'] = Auth::id();
                break;
            case 2:
                $updateData['status_id'] = 3;
                $updateData['end_at'] = now();
                break;
        }
        event(new OrderStatusUpdated($order));
        $order->update($updateData);
        return redirect()->route('order.index');
    }

    /**
     * Devuelve la ruta adecuada para redirigir a la vista de índice de órdenes dependiendo de la ruta actual.
     *
     * Si la ruta actual es "order.consultation.show", redirige a "order.consultation.index".
     * Si la ruta actual es "order.show", redirige a "order.index".
     * Si la ruta actual es "order.group.show", redirige a "order.group.index".
     * En cualquier otro caso, redirige a "order.index".
     *
     * @return string La ruta de redirección adecuada.
     */
    public function getRedirectRouteToIndex()
    {
        if (request()->routeIs('order.consultation.show')) {
            return route('order.consultation.index');
        } elseif (request()->routeIs('order.show')) {
            return route('order.index');
        } elseif (request()->routeIs('order.group.show')) {
            return route('order.group.index');
        }

        return route('order.index');
    }

    /**
     * Aplica filtros a la consulta de órdenes basados en los parámetros presentes en la solicitud.
     * 
     * Esta función verifica si los campos de filtro específicos (`resolution_area`, `type`, `status`)
     * están presentes y completos en la solicitud, y aplica los filtros correspondientes en la consulta.
     * Si no se proporciona ningún filtro, se muestra todas las órdenes.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los filtros a aplicar.
     * @param \Illuminate\Database\Eloquent\Builder $query La consulta de Eloquent a la que se le aplicarán los filtros.
     * 
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Support\HigherOrderTapProxy|string La consulta modificada con los filtros aplicados, 
     *         o un mensaje en caso de no aplicar ningún filtro.
     */
    public static function applyFilters(Request $request, $query)
    {
        return match (true) {
            $request->filled('resolution_area') => tap('Buscando órdenes por área de resolución.', fn() =>
                $query->where('resolution_area_id', 'LIKE', "%{$request->resolution_area}%")),
            $request->filled('type') => tap('Buscando órdenes por tipo.', fn() =>
                $query->where('type_id', 'LIKE', "%{$request->type}%")),
            $request->filled('status') => tap('Buscando órdenes por estado.', fn() =>
                $query->where('status_id', 'LIKE', "%{$request->status}%")),
            default => 'Mostrando todas las órdenes.'
        };
    }

    /**
     * Obtiene el mensaje que se mostrará cuando no se encuentren órdenes que coincidan con los filtros aplicados.
     * 
     * Esta función verifica si los filtros de la solicitud (`resolution_area`, `type`, `status`) están presentes
     * y devuelve un mensaje adecuado en función del filtro que no haya producido resultados. Si no se aplicaron filtros,
     * devuelve un mensaje genérico indicando que no se encontraron órdenes.
     *
     * @param \Illuminate\Http\Request $request La solicitud HTTP que contiene los filtros aplicados.
     * 
     * @return string El mensaje que describe la situación de los resultados de la búsqueda de órdenes.
     */
    public static function getEmptyOrdersMessage(Request $request)
    {
        return match (true) {
            $request->filled('resolution_area') => 'No se encontraron órdenes para el área de resolución proporcionada.',
            $request->filled('type') => 'No se encontraron órdenes del tipo proporcionado.',
            $request->filled('status') => 'No se encontraron órdenes con el estado proporcionado.',
            default => 'No se encontraron órdenes.'
        };
    }
    /**
     * Obtiene la ruta de redirección adecuada para mostrar una orden.
     * 
     * Esta función determina la ruta de redirección a partir de la ruta actual en la que se encuentra la solicitud.
     * Dependiendo de si la ruta actual es una de las siguientes:
     * - `order.group.index` o `order.group.show`, redirige a la ruta de visualización del grupo de órdenes.
     * - `order.consultation.index`, redirige a la ruta de visualización de la consulta de órdenes.
     * - Cualquier otra ruta, redirige a la ruta de visualización estándar de la orden.
     * 
     * Si no se proporciona un objeto de orden, se pasa `null`, en cuyo caso se redirige a la ruta adecuada sin detalles de la orden.
     * 
     * @param \App\Models\Order|null $order El objeto de la orden a mostrar. Si no se proporciona, se asume que no hay orden específica.
     * 
     * @return string La ruta de redirección adecuada para la orden.
     */
    public static function getRedirectRouteToShow(?Order $order = null)
    {
        if (request()->routeIs('order.group.index') || request()->routeIs('order.group.show')) {
            return route('order.group.show', $order);
        }

        return request()->routeIs('order.consultation.index') ? route('order.consultation.show', $order) : route('order.show', $order);
    }
}



