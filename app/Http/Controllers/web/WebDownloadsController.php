<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebDownloadsController
{
    public function get_downloads_index()
    {
        $Web = new Web($this);
        //各種ダウンロード カテゴリ
        $info_downloads_category = $Web->web_search_downloads_category();
        foreach ($info_downloads_category as $k=>$v){
            $info_downloads_category[$k]['DOWNLOADS_ARR'] = $Web->web_search_category_downloads_arr($v['id']);
        }
        $this->data['info_downloads_category'] = $info_downloads_category;
        return view('web/downloads/index',$this->data);
    }

}
