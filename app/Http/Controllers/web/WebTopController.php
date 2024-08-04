<?php

namespace App\Http\Controllers\web;

use App\Models\Web;
use Illuminate\Support\Facades\Date;

class WebTopController
{
    public function get_top_index()
    {
        $Web = new Web($this);

        $params = array();
        //新着情報
        $params['n_important_flg'] = 1;
        $info_important_news = $Web->web_search_news($params);
        foreach ($info_important_news as $k=>$v){
            $info_important_news[$k]['n_open_date'] = date('Y-m-d',strtotime($v['n_open_date']));
        }

        //新着情報
        $params['n_important_flg'] = 0;
        $info_unimportant_news = $Web->web_search_news($params);
        foreach ($info_unimportant_news as $k=>$v){
            $info_unimportant_news[$k]['n_open_date'] = date('Y-m-d',strtotime($v['n_open_date']));
        }

        //製品情報-バナー
        $info_product_banners = $Web->web_search_product_banners();

        //企業
        $info_company = $Web->web_search_company();

        //セミナー
        $date = date('Y-m-d',time());
        $info_seminars_exhibitions = $Web->web_search_seminars_exhibitions(1,$date);
        if (!empty($info_seminars_exhibitions)){
            $daysOfWeek = [
                1 => '月',
                2 => '火',
                3 => '水',
                4 => '木',
                5 => '金',
                6 => '土',
                7 => '日'
            ];
            foreach ($info_seminars_exhibitions as $k=>$v){
                if (!empty($v['exhibition_dates1'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates1_date'] = date('m/d',strtotime($v['exhibition_dates1']));
                    $info_seminars_exhibitions[$k]['exhibition_dates1_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates1']))];
                }
                if (!empty($v['exhibition_dates2'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates2_date'] = "・".date('m/d',strtotime($v['exhibition_dates2']));
                    $info_seminars_exhibitions[$k]['exhibition_dates2_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates2']))];
                }
                if (!empty($v['exhibition_dates3'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates3_date'] = "・".date('m/d',strtotime($v['exhibition_dates3']));
                    $info_seminars_exhibitions[$k]['exhibition_dates3_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates3']))];
                }
                if (!empty($v['exhibition_dates4'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates4_date'] = "・".date('m/d',strtotime($v['exhibition_dates4']));
                    $info_seminars_exhibitions[$k]['exhibition_dates4_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates4']))];
                }
                if (!empty($v['exhibition_dates5'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates5_date'] = "・".date('m/d',strtotime($v['exhibition_dates5']));
                    $info_seminars_exhibitions[$k]['exhibition_dates5_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates5']))];
                }
                if (!empty($v['exhibition_dates6'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates6_date'] = "・".date('m/d',strtotime($v['exhibition_dates6']));
                    $info_seminars_exhibitions[$k]['exhibition_dates6_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates6']))];
                }
                if (!empty($v['exhibition_dates7'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates7_date'] = "・".date('m/d',strtotime($v['exhibition_dates7']));
                    $info_seminars_exhibitions[$k]['exhibition_dates7_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates7']))];
                }
                if (!empty($v['exhibition_dates8'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates8_date'] = "・".date('m/d',strtotime($v['exhibition_dates8']));
                    $info_seminars_exhibitions[$k]['exhibition_dates8_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates8']))];
                }
                if (!empty($v['exhibition_dates9'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates9_date'] = "・".date('m/d',strtotime($v['exhibition_dates9']));
                    $info_seminars_exhibitions[$k]['exhibition_dates9_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates9']))];
                }
                if (!empty($v['exhibition_dates10'])){
                    $info_seminars_exhibitions[$k]['exhibition_dates10_date'] = "・".date('m/d',strtotime($v['exhibition_dates10']));
                    $info_seminars_exhibitions[$k]['exhibition_dates10_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates10']))];
                }

                //タグ名
                $SEMINARS_EXHIBITIONS_LABLES_ARR = array();
                if (!empty($v['c_lables'])){
                    $c_lables_arr = explode(',', $v['c_lables']);
                    foreach ($c_lables_arr as $v){
                        $SEMINARS_EXHIBITIONS_LABLES_INFO = $Web->web_search_SEMINARS_EXHIBITIONS_LABLES_ID_info($v);
                        $SEMINARS_EXHIBITIONS_LABLES_ARR[] = $SEMINARS_EXHIBITIONS_LABLES_INFO['s_name'];
                    }
                }
                $info_seminars_exhibitions[$k]['SEMINARS_EXHIBITIONS_LABLES_ARR'] = $SEMINARS_EXHIBITIONS_LABLES_ARR;
            }
        }

        $this->data['info_seminars_exhibitions'] = $info_seminars_exhibitions;
        $this->data['info_company'] = $info_company;
        $this->data['info_product_banners'] = $info_product_banners;
        $this->data['info_important_news'] = $info_important_news;
        $this->data['info_unimportant_news'] = $info_unimportant_news;

        return view('web/top/index',$this->data);
    }
}
