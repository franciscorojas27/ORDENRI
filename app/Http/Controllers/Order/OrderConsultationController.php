<?php

namespace App\Http\Controllers\Order;


use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

use function Pest\Laravel\handleValidationExceptions;

class OrderConsultationController extends Controller
{
    public function index(Request $request)
    {   
        if($request->filled('month') && $request->filled('year')) {
            $validator = Validator::make($request->all(), [
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer|digits:4|between:' . (date('Y') - 5) . ',' . date('Y'),
            ]);
            if ($validator->fails()) {
                return redirect()->route('order.consultation.index');
            }
            $orders = Order::whereYear('created_at', $request->year)
                ->whereMonth('created_at', $request->month)
                ->orderBy('created_at', 'asc')
                ->get();
            session()->flash('message', 'Se encontraron '. $orders->count() . ' ordenes para el mes ' . $request->month . ' del año ' . $request->year . '.');
            return view('order-consultation.index', compact('orders'));
        }
        return view('order-consultation.index');

    }

    public function show(Order $order)
    {
        return view('order-consultation.show', compact('order'));
    }
    public function download(Order $order)
    {
        $pdf = Pdf::loadView('pdf.order-consultation', compact('order'));
        return $pdf->download("Orden de Servicio n° {$order->id}.pdf");
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return redirect()->back()->withInput();
    }
}
