<?php

namespace App\Http\Controllers\web;

class WebPrivacyController
{
    public function get_privacy_index()
    {
        return view('web/privacy/index');
    }

}
