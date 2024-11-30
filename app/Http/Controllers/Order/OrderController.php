<?php

namespace App\Http\Controllers\Order;

use App\Models\Type;
use App\Models\User;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Mail\OrderStartEndMail;
use App\Models\Resolution_Area;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use \Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Requests\UpdateOrderRequest;

class OrderController extends Controller
{
    /**
     * Muestra una lista de órdenes filtradas según el rol del usuario autenticado.
     * Dependiendo del tipo de usuario (Administrador, Cliente o cualquier otro rol),
     * la consulta se ajusta para mostrar las órdenes correspondientes.
     * 
     * @param Request $request La solicitud HTTP que contiene los filtros de búsqueda.
     * @return \Illuminate\View\View La vista que muestra las órdenes filtradas.
     */
    public function index(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Consulta base para obtener órdenes que no están marcadas como eliminadas
        $query = Order::with('applicantTo', 'type', 'resolutionArea', 'status')
            ->where('is_deleted', 'false'); // Este filtro es común para todos los usuarios

        // Ajustar la consulta según el tipo de usuario
        if ($user->jobTitle->title === 'Cliente') {
            // Para los clientes, se filtran las órdenes según su ID y área de resolución
            $query->where('client_id', $user->id);
        } elseif ($user->jobTitle->title !== 'Administrador') {
            // Para otros roles, se filtra solo por el área de resolución
            $query->where('resolution_area_id', $user->resolution_area_id);
        }

        // Aplicar los filtros adicionales basados en los parámetros de la solicitud
        $message = $this->applyFilters($request, $query);

        // Verificar si la consulta no devuelve resultados y mostrar un mensaje en consecuencia
        if ($query->count() === 0) {
            // Si no se encontraron órdenes, se muestra un mensaje personalizado
            session()->flash('message', $this->getEmptyOrdersMessage($request));
        } else {
            // Si se encontraron resultados, se muestra el mensaje generado por los filtros
            session()->flash('message', $message);
        }

        // Retornar la vista con las órdenes filtradas y otros datos necesarios
        return view('order.index', [
            'orders' => $query->orderBy('id', 'desc')->paginate(30), // Paginación de resultados
            'types' => Type::all(), // Obtener todos los tipos de órdenes
            'resolution_areas' => Resolution_Area::all(), // Obtener todas las áreas de resolución
            'statuses' => Status::all(), // Obtener todos los estados de las órdenes
            'getRedirectRoute' => fn($order) => $this->getRedirectRouteToShow($order), // Función para redirigir a la vista de detalle de la orden
        ]);
    }

    public function create()
    {

        return view('order.create', ['types' => Type::all(), 'resolution_areas' => Resolution_Area::all()]);
    }

    public function store(StoreOrderRequest $request)
    {
        $order = Order::create([
            'client_id' => $request->input('user_id'),
            'resolution_area_id' => $request->input('resolution_areas'),
            'type_id' => $request->input('types'),
            'client_description' => $request->description,
            'status_id' => 1
        ]);
        $order->load(['client', 'applicantTo', 'responsible']);
        $emails = collect([
            $order->client?->email,
            $order->applicantTo?->email,
            $order->responsible?->email,
            'arojas@cantv.com.ve'
        ])->filter()
            ->concat(User::where('resolution_area_id', $order->resolution_area_id)
                ->pluck('email'));
        Mail::to($emails)->queue(new OrderStartEndMail($order));
        return redirect()->route('order.index');
    }


    public function show(Order $order)
    {
        $redirectRoute = $this->getRedirectRouteToIndex();

        return view('order.show', compact('order', 'redirectRoute'));
    }


    public function edit(Order $order)
    {
        return view('order.edit', ['RST' => $order::getSelectOptions(), 'order' => $order->getUserRelationsAttribute(), 'users' => User::getBasicUserInfo()]);
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->updateFields());
        $order->load(['client', 'applicantTo', 'responsible']);
        $emails = collect([
            $order->client?->email,
            $order->applicantTo?->email,
            $order->responsible?->email,
            'arojas@cantv.com.ve'
        ])->filter()
            ->concat(User::where('resolution_area_id', $order->resolution_area_id)
                ->pluck('email'));
        Mail::to($emails)->queue(new OrderStartEndMail($order));
        return redirect()->route('order.index');
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
        $order->update($updateData);

        $order->load(['client', 'applicantTo', 'responsible']);
        $emails = collect([
            $order->client?->email,
            $order->applicantTo?->email,
            $order->responsible?->email,
            'arojas@cantv.com.ve'
        ])->filter()
            ->concat(User::where('resolution_area_id', $order->resolution_area_id)
                ->pluck('email'));
        Mail::to($emails)->queue(new OrderStartEndMail($order));

        return redirect()->route('order.index');
    }
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



