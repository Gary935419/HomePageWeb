<?php

namespace App\Http\Controllers\web;

class WebSimulationsController
{
    public function get_simulations_index()
    {
        return view('web/simulations/index');
    }

}
