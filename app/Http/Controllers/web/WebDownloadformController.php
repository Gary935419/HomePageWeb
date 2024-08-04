<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebDownloadformController
{
    public function get_downloadform_index($id)
    {
        $Web = new Web($this);
        //ダウンロード
        $info_download = $Web->web_search_downloads_id_info($id);

        $this->data['info_download'] = $info_download;
        $this->data['id'] = $id ?? '';
        return view('web/downloadform/index',$this->data);
    }

    public function get_downloadform_thanks()
    {
        $paramsAll = request()->all();
        $id = $paramsAll['id'] ?? 0;
        $phone_number = $paramsAll['phone_number'] ?? 0;
        $email = $paramsAll['email'] ?? 0;
        $Web = new Web($this);
        //ダウンロード履歴
        $info_downloads_history = $Web->web_search_downloads_history_id_info($id,$phone_number,$email);
        $this->data['info_downloads_history'] = $info_downloads_history;
        return view('web/downloadform/thanks',$this->data);
    }
}
