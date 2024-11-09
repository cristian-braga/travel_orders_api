<?php

namespace App\Http\Controllers;

use App\Models\TravelOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TravelOrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $travel_orders = TravelOrder::when($status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('id', 'asc')
            ->paginate();

        return response()->json($travel_orders);
    }

    public function store(Request $request)
    {
        $data = Validator::make($request->all(), [
            'solicitante' => 'required',
            'destino' => 'required',
            'data_ida' => 'required|after_or_equal:today',
            'data_volta' => 'required|after:data_ida'
        ], [
            'solicitante.required' => 'O campo "solicitante" é obrigatório.',
            'destino.required' => 'O campo "destino" é obrigatório.',
            'data_ida.required' => 'A "data de ida" é obrigatória.',
            'data_ida.after_or_equal' => 'A data de ida deve ser uma data futura ou igual a hoje.',
            'data_volta.required' => 'A "data de volta" é obrigatória.',
            'data_volta.after' => 'A data de volta deve ser posterior à data de ida.'
        ]);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        $travel_order = TravelOrder::create($data->validated());

        return response()->json([
            'message' => 'Pedido cadastrado com sucesso!',
            'travel_order' => $travel_order
        ], 201);
    }

    public function show($id)
    {
        $travel_order = TravelOrder::find($id);

        if (!$travel_order) {
            return response()->json(['error' => 'Pedido não encontrado!'], 404);
        }

        return response()->json(['travel_order' => $travel_order]);
    }

    public function update(Request $request, $id)
    {
        $travel_order = TravelOrder::find($id);

        if (!$travel_order) {
            return response()->json(['error' => 'Pedido não encontrado!'], 404);
        }

        $data = Validator::make($request->all(), [
            'status' => 'required|in:aprovado,cancelado'
        ], [
            'status.required' => 'O campo "status" é obrigatório.',
            'status.in' => 'O status precisa ser: :values.'
        ]);

        if ($data->fails()) {
            return response()->json(['error' => $data->errors()], 400);
        }

        $travel_order->update($data->validated());

        return response()->json([
            'message' => 'Pedido atualizado com sucesso!',
            'travel_order' => $travel_order
        ]);
    }
}
