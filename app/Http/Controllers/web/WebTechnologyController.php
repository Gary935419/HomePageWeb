<?php

namespace App\Http\Controllers\web;

class WebTechnologyController
{
    public function get_technology_index()
    {
        return view('web/technology/index');
    }
}
