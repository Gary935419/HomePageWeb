<?php

namespace App\Http\Controllers\web;

class WebAboutusController
{
    public function get_aboutus_index()
    {
        return view('web/aboutus/index');
    }
    public function get_aboutus_business()
    {
        return view('web/aboutus/business');
    }
    public function get_aboutus_history()
    {
        return view('web/aboutus/history');
    }
    public function get_aboutus_message()
    {
        return view('web/aboutus/message');
    }
    public function get_aboutus_movie()
    {
        return view('web/aboutus/movie');
    }
    public function get_aboutus_team()
    {
        return view('web/aboutus/team');
    }
}
