<?php

namespace App\Http\Controllers\api\web;

use App\Models\Web;

class ProductsController extends Controller
{
    public function post_products_search()
    {
        try {
            $paramsAll = request()->all();
            $lables_arr = array();
            if (isset($paramsAll['id']) && !empty($paramsAll['id'])){
                $lables_arr[] = $paramsAll['id'];
            }
            $Web = new Web($this);

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
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。','DATA' => $info_product));
        } catch (\Exception $e) {
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
