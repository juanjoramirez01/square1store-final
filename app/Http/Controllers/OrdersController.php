<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use NumberFormatter;

class OrdersController extends Controller
{
    public function __invoke()
    {

        /*$orders = Order::where('user_id', auth()->id())->paginate(3)->map(function ($order){
            $order->formatted_price = $this->formatCurrent($order->price);
            return $order;
        });*/

        $orders = Order::where('user_id', auth()->id())->paginate(3);

        return view('pages.orders', [
            'orders' => $orders
        ]);
    }

    public function formatCurrent(float $amount)
    {
       $formater =  new NumberFormatter(config('app.locale'), NumberFormatter::CURRENCY);
       return $formater->formatCurrency($amount, 'USD');
    }
}
