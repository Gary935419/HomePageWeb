<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebCustomersController
{
    public function get_customers_index()
    {
        $paramsAll = request()->all();
        $this->data['p_type1'] = "";
        $this->data['p_type2'] = "";
        $this->data['p_type3'] = "";
        $this->data['p_type4'] = "";
        $p_type_arr = array();
        if (isset($paramsAll['p_type1']) && !empty($paramsAll['p_type1'])){
            $this->data['p_type1'] = $paramsAll['p_type1'];
            $p_type_arr[] = $paramsAll['p_type1'];
        }
        if (isset($paramsAll['p_type2']) && !empty($paramsAll['p_type2'])){
            $this->data['p_type2'] = $paramsAll['p_type2'];
            $p_type_arr[] = $paramsAll['p_type2'];
        }
        if (isset($paramsAll['p_type3']) && !empty($paramsAll['p_type3'])){
            $this->data['p_type3'] = $paramsAll['p_type3'];
            $p_type_arr[] = $paramsAll['p_type3'];
        }
        if (isset($paramsAll['p_type4']) && !empty($paramsAll['p_type4'])){
            $this->data['p_type4'] = $paramsAll['p_type4'];
            $p_type_arr[] = $paramsAll['p_type4'];
        }

        $Web = new Web($this);

        //導入事例
        $info_recedents = $Web->web_search_precedents();
        foreach ($info_recedents as $k=>$v){
            //タグ名
            $PRODECT_LABLES_ARR = array();
            if (!empty($v['pr_labels'])){
                $pr_labels_arr = explode(',', $v['pr_labels']);
                foreach ($pr_labels_arr as $vv){
                    $PRODECT_LABLES_INFO = $Web->web_search_prodect_lables_id_info($vv);
                    if (!empty($PRODECT_LABLES_INFO['p_name'])){
                        $PRODECT_LABLES_ARR[] = $PRODECT_LABLES_INFO['p_name'];
                    }
                }
            }
            $info_recedents[$k]['PRODECT_LABLES_ARR'] = $PRODECT_LABLES_ARR;
        }
        $this->data['info_recedents'] = $info_recedents;

        //業種別
        $info_prodect_lables1 = $Web->web_search_prodect_lables(1);
        $this->data['info_prodect_lables1'] = $info_prodect_lables1;
        //点呼種別
        $info_prodect_lables2 = $Web->web_search_prodect_lables(2);
        $this->data['info_prodect_lables2'] = $info_prodect_lables2;
        //製品別
        $info_prodect_lables3 = $Web->web_search_prodect_lables(3);
        $this->data['info_prodect_lables3'] = $info_prodect_lables3;
        //その他
        $info_prodect_lables4 = $Web->web_search_prodect_lables(4);
        $this->data['info_prodect_lables4'] = $info_prodect_lables4;

        //導入企業
        $info_company = $Web->web_search_company_by_lables($p_type_arr);
        $this->data['info_company'] = $info_company;

        return view('web/customers/index',$this->data);
    }
    public function get_customers_detail($id)
    {

        $Web = new Web($this);
        //事例Details
        $info_precedents = $Web->web_search_precedents_id_info($id);

        //タグ名
        $PRODECT_LABLES_ARR = array();
        if (!empty($info_precedents['pr_labels'])){
            $pr_labels_arr = explode(',', $info_precedents['pr_labels']);
            foreach ($pr_labels_arr as $vv){
                $PRODECT_LABLES_INFO = $Web->web_search_prodect_lables_id_info($vv);
                if (!empty($PRODECT_LABLES_INFO['p_name'])){
                    $PRODECT_LABLES_ARR[] = $PRODECT_LABLES_INFO['p_name'];
                }
            }
        }
        $info_precedents['PRODECT_LABLES_ARR'] = $PRODECT_LABLES_ARR;
        $this->data['info_precedents'] = $info_precedents;

        //事例Details Before
        $this->data['before_id'] = "";
        $info_precedents = $Web->web_search_precedents_id_info_before_after($id,1);
        if (!empty($info_precedents)){
            $this->data['before_id'] = $info_precedents['id'];
        }
        //事例Details After
        $this->data['after_id'] = "";
        $info_precedents = $Web->web_search_precedents_id_info_before_after($id,2);
        if (!empty($info_precedents)){
            $this->data['after_id'] = $info_precedents['id'];
        }

        return view('web/customers/detail',$this->data);
    }
}
