<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebDownloadProductsController
{
    public function get_download_products_index($id)
    {
        $Web = new Web($this);
        $info_download = $Web->select_S_PRODUCT_INFORMATION_ID_info($id);
        if (empty($info_download)){
            return redirect('/');
        }
        $this->data['info_download'] = $info_download;
        $this->data['id'] = $id ?? '';
        return view('web/downloadproducts/index',$this->data);
    }

    public function get_download_products_thanks()
    {
        $paramsAll = request()->all();
        $id = $paramsAll['id'] ?? 0;
        $phone_number = $paramsAll['phone_number'] ?? 0;
        $email = $paramsAll['email'] ?? 0;
        $Web = new Web($this);
        //ダウンロード履歴
        $info_downloads_history = $Web->web_search_downloads_history_id_info($id,$phone_number,$email,1);
        $this->data['info_downloads_history'] = $info_downloads_history;
        return view('web/downloadproducts/thanks',$this->data);
    }
}
