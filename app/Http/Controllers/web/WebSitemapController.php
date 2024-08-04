<?php

namespace App\Http\Controllers\web;

class WebSitemapController
{
    public function get_sitemap_index()
    {
        return view('web/sitemap/index');
    }
}
