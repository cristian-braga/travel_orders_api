<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTravelOrderRequest;
use App\Http\Requests\UpdateTravelOrderRequest;
use App\Http\Resources\TravelOrderResource;
use App\Models\TravelOrder;
use Illuminate\Http\Request;

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

        return TravelOrderResource::collection($travel_orders);
    }

    public function store(StoreTravelOrderRequest $request)
    {
        $data = $request->validated();

        $travel_order = TravelOrder::create($data);

        return TravelOrderResource::make($travel_order)->additional(['message' => 'Pedido cadastrado com sucesso!']);
    }

    public function show($id)
    {
        $travel_order = TravelOrder::find($id);

        if (!$travel_order) {
            return response()->json(['error' => 'Pedido não encontrado!'], 404);
        }

        return TravelOrderResource::make($travel_order);
    }

    public function update(UpdateTravelOrderRequest $request, $id)
    {
        $travel_order = TravelOrder::find($id);

        if (!$travel_order) {
            return response()->json(['error' => 'Pedido não encontrado!'], 404);
        }

        $data = $request->validated();

        $travel_order->update($data);

        return TravelOrderResource::make($travel_order)->additional(['message' => 'Pedido atualizado com sucesso!']);
    }
}
