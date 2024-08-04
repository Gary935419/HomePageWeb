<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebProductsController
{
    public function get_products_index()
    {
        $paramsAll = request()->all();
        $this->data['id'] = "";
        $lables_arr = array();
        if (isset($paramsAll['id']) && !empty($paramsAll['id'])){
            $this->data['id'] = $paramsAll['id'];
            $lables_arr[] = $paramsAll['id'];
        }
        $Web = new Web($this);
        //製品情報-タグ
        $info_product_lables = $Web->web_search_product_lables();
        $this->data['info_product_lables'] = $info_product_lables;


        //製品情報
        $info_product = $Web->web_search_product($lables_arr);
        foreach ($info_product as $k=>$v){
            //タグ名
            $PRODUCT_LABLES_ARR = array();
            if (!empty($v['p_lables'])){
                $c_lables_arr = explode(',', $v['p_lables']);
                foreach ($c_lables_arr as $vv){
                    $SEMINARS_EXHIBITIONS_LABLES_INFO = $Web->web_search_product_lables_id_info($vv);
                    if (!empty($SEMINARS_EXHIBITIONS_LABLES_INFO['pr_name'])){
                        $PRODUCT_LABLES_ARR[] = $SEMINARS_EXHIBITIONS_LABLES_INFO['pr_name'];
                    }
                }
            }
            $info_product[$k]['PRODUCT_LABLES_ARR'] = $PRODUCT_LABLES_ARR;
        }
        $this->data['info_product'] = $info_product;
        return view('web/products/index',$this->data);
    }
}
