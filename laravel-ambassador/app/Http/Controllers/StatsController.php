<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatsResource;
use App\Models\Link;
use App\Models\Order;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function index(Request $request)
    {
        $links = auth()->user()->links()->get();

        return $links->map(function (Link $link) {
            $orders = Order::where('code', $link->code)->get();
            return [
                'code' => $link->code,
                'count' => $orders->count(),
                'revenue' => $orders->sum(fn (Order $order) => $order->ambassadorRevenue)
            ];
        });
    }
}
