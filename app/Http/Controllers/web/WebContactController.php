<?php

namespace App\Http\Controllers\web;

class WebContactController
{
    public function get_contact_index()
    {
        return view('web/contact/index');
    }

    public function get_contact_thanks()
    {
        return view('web/contact/thanks');
    }
}
