<?php

namespace App\Http\Controllers\web;

class WebOrderController
{
    public function get_order_index()
    {
        return view('web/order/index');
    }
}
