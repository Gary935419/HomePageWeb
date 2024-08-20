<?php

namespace App\Http\Controllers\api\web;

use App\Models\Web;

class CustomersController extends Controller
{
    public function post_customers_search()
    {
        try {
            $paramsAll = request()->all();
            $p_type1_arr = array();
            $p_type2_arr = array();
            $p_type3_arr = array();
            $p_type4_arr = array();
            if (isset($paramsAll['p_type1']) && !empty($paramsAll['p_type1'])){
                $p_type1_arr = explode(',', $paramsAll['p_type1']);
            }
            if (isset($paramsAll['p_type2']) && !empty($paramsAll['p_type2'])){
                $p_type2_arr = explode(',', $paramsAll['p_type2']);
            }
            if (isset($paramsAll['p_type3']) && !empty($paramsAll['p_type3'])){
                $p_type3_arr = explode(',', $paramsAll['p_type3']);
            }
            if (isset($paramsAll['p_type4']) && !empty($paramsAll['p_type4'])){
                $p_type4_arr = explode(',', $paramsAll['p_type4']);
            }

            $p_type_arr = array_merge($p_type1_arr, $p_type2_arr, $p_type3_arr, $p_type4_arr);
            $Web = new Web($this);
            //導入企業
            $info_company = $Web->web_search_company_by_lables($p_type_arr);
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。','DATA' => $info_company));
        } catch (\Exception $e) {
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
