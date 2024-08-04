<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebManagementController
{
    public function get_management_index()
    {
        $Web = new Web($this);
        //各種ダウンロード カテゴリ
        $info_management_site = $Web->web_search_management_site();
        $this->data['info_management_site'] = $info_management_site;
        return view('web/management/index',$this->data);
    }
}
