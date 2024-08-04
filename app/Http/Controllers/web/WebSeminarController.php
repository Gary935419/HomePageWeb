<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebSeminarController
{
    public function get_seminar_index()
    {
        $Web = new Web($this);
        $date = date('Y-m-d',time());
        //セミナー
        $info_seminars = $Web->web_search_seminars_exhibitions(1,$date);
        if (!empty($info_seminars)){
            $daysOfWeek = [
                1 => '月',
                2 => '火',
                3 => '水',
                4 => '木',
                5 => '金',
                6 => '土',
                7 => '日'
            ];
            foreach ($info_seminars as $k=>$v){
                if (!empty($v['exhibition_dates1'])){
                    $info_seminars[$k]['exhibition_dates1_date'] = date('m/d',strtotime($v['exhibition_dates1']));
                    $info_seminars[$k]['exhibition_dates1_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates1']))];
                }
                if (!empty($v['exhibition_dates2'])){
                    $info_seminars[$k]['exhibition_dates2_date'] = "・".date('m/d',strtotime($v['exhibition_dates2']));
                    $info_seminars[$k]['exhibition_dates2_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates2']))];
                }
                if (!empty($v['exhibition_dates3'])){
                    $info_seminars[$k]['exhibition_dates3_date'] = "・".date('m/d',strtotime($v['exhibition_dates3']));
                    $info_seminars[$k]['exhibition_dates3_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates3']))];
                }
                if (!empty($v['exhibition_dates4'])){
                    $info_seminars[$k]['exhibition_dates4_date'] = "・".date('m/d',strtotime($v['exhibition_dates4']));
                    $info_seminars[$k]['exhibition_dates4_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates4']))];
                }
                if (!empty($v['exhibition_dates5'])){
                    $info_seminars[$k]['exhibition_dates5_date'] = "・".date('m/d',strtotime($v['exhibition_dates5']));
                    $info_seminars[$k]['exhibition_dates5_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates5']))];
                }
                if (!empty($v['exhibition_dates6'])){
                    $info_seminars[$k]['exhibition_dates6_date'] = "・".date('m/d',strtotime($v['exhibition_dates6']));
                    $info_seminars[$k]['exhibition_dates6_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates6']))];
                }
                if (!empty($v['exhibition_dates7'])){
                    $info_seminars[$k]['exhibition_dates7_date'] = "・".date('m/d',strtotime($v['exhibition_dates7']));
                    $info_seminars[$k]['exhibition_dates7_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates7']))];
                }
                if (!empty($v['exhibition_dates8'])){
                    $info_seminars[$k]['exhibition_dates8_date'] = "・".date('m/d',strtotime($v['exhibition_dates8']));
                    $info_seminars[$k]['exhibition_dates8_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates8']))];
                }
                if (!empty($v['exhibition_dates9'])){
                    $info_seminars[$k]['exhibition_dates9_date'] = "・".date('m/d',strtotime($v['exhibition_dates9']));
                    $info_seminars[$k]['exhibition_dates9_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates9']))];
                }
                if (!empty($v['exhibition_dates10'])){
                    $info_seminars[$k]['exhibition_dates10_date'] = "・".date('m/d',strtotime($v['exhibition_dates10']));
                    $info_seminars[$k]['exhibition_dates10_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates10']))];
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
                $info_seminars[$k]['SEMINARS_EXHIBITIONS_LABLES_ARR'] = $SEMINARS_EXHIBITIONS_LABLES_ARR;
            }
        }

        //展示会
        $info_exhibitions = $Web->web_search_seminars_exhibitions(2,$date);
        if (!empty($info_exhibitions)){
            $daysOfWeek = [
                1 => '月',
                2 => '火',
                3 => '水',
                4 => '木',
                5 => '金',
                6 => '土',
                7 => '日'
            ];
            foreach ($info_exhibitions as $k=>$v){
                if (!empty($v['exhibition_dates1'])){
                    $info_exhibitions[$k]['exhibition_dates1_date'] = date('m/d',strtotime($v['exhibition_dates1']));
                    $info_exhibitions[$k]['exhibition_dates1_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates1']))];
                }
                if (!empty($v['exhibition_dates2'])){
                    $info_exhibitions[$k]['exhibition_dates2_date'] = "・".date('m/d',strtotime($v['exhibition_dates2']));
                    $info_exhibitions[$k]['exhibition_dates2_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates2']))];
                }
                if (!empty($v['exhibition_dates3'])){
                    $info_exhibitions[$k]['exhibition_dates3_date'] = "・".date('m/d',strtotime($v['exhibition_dates3']));
                    $info_exhibitions[$k]['exhibition_dates3_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates3']))];
                }
                if (!empty($v['exhibition_dates4'])){
                    $info_exhibitions[$k]['exhibition_dates4_date'] = "・".date('m/d',strtotime($v['exhibition_dates4']));
                    $info_exhibitions[$k]['exhibition_dates4_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates4']))];
                }
                if (!empty($v['exhibition_dates5'])){
                    $info_exhibitions[$k]['exhibition_dates5_date'] = "・".date('m/d',strtotime($v['exhibition_dates5']));
                    $info_exhibitions[$k]['exhibition_dates5_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates5']))];
                }
                if (!empty($v['exhibition_dates6'])){
                    $info_exhibitions[$k]['exhibition_dates6_date'] = "・".date('m/d',strtotime($v['exhibition_dates6']));
                    $info_exhibitions[$k]['exhibition_dates6_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates6']))];
                }
                if (!empty($v['exhibition_dates7'])){
                    $info_exhibitions[$k]['exhibition_dates7_date'] = "・".date('m/d',strtotime($v['exhibition_dates7']));
                    $info_exhibitions[$k]['exhibition_dates7_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates7']))];
                }
                if (!empty($v['exhibition_dates8'])){
                    $info_exhibitions[$k]['exhibition_dates8_date'] = "・".date('m/d',strtotime($v['exhibition_dates8']));
                    $info_exhibitions[$k]['exhibition_dates8_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates8']))];
                }
                if (!empty($v['exhibition_dates9'])){
                    $info_exhibitions[$k]['exhibition_dates9_date'] = "・".date('m/d',strtotime($v['exhibition_dates9']));
                    $info_exhibitions[$k]['exhibition_dates9_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates9']))];
                }
                if (!empty($v['exhibition_dates10'])){
                    $info_exhibitions[$k]['exhibition_dates10_date'] = "・".date('m/d',strtotime($v['exhibition_dates10']));
                    $info_exhibitions[$k]['exhibition_dates10_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates10']))];
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
                $info_exhibitions[$k]['SEMINARS_EXHIBITIONS_LABLES_ARR'] = $SEMINARS_EXHIBITIONS_LABLES_ARR;
            }
        }


        //講師
        $info_teacher = $Web->web_search_teacher();

        $this->data['info_teacher'] = $info_teacher;
        $this->data['info_seminars'] = $info_seminars;
        $this->data['info_exhibitions'] = $info_exhibitions;

        return view('web/seminar/index',$this->data);
    }

    public function get_seminar_fix()
    {
        $paramsAll = request()->all();
        $page = $paramsAll['page'] ?? 1;
        $Web = new Web($this);
        $date = date('Y-m-d',time());
        //セミナー展示会
        $allPage = $Web->web_search_seminars_exhibitions_close_all_page($date);
        $page = $allPage > $page ? $page : $allPage;
        $this->data['pageHtml'] = getPage($page,$allPage,$paramsAll);
        $info_seminars = $Web->web_search_seminars_exhibitions_close_all($date,$page);
        if (!empty($info_seminars)){
            $daysOfWeek = [
                1 => '月',
                2 => '火',
                3 => '水',
                4 => '木',
                5 => '金',
                6 => '土',
                7 => '日'
            ];
            foreach ($info_seminars as $k=>$v){
                if (!empty($v['exhibition_dates1'])){
                    $info_seminars[$k]['exhibition_dates1_date'] = date('m/d',strtotime($v['exhibition_dates1']));
                    $info_seminars[$k]['exhibition_dates1_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates1']))];
                }
                if (!empty($v['exhibition_dates2'])){
                    $info_seminars[$k]['exhibition_dates2_date'] = "・".date('m/d',strtotime($v['exhibition_dates2']));
                    $info_seminars[$k]['exhibition_dates2_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates2']))];
                }
                if (!empty($v['exhibition_dates3'])){
                    $info_seminars[$k]['exhibition_dates3_date'] = "・".date('m/d',strtotime($v['exhibition_dates3']));
                    $info_seminars[$k]['exhibition_dates3_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates3']))];
                }
                if (!empty($v['exhibition_dates4'])){
                    $info_seminars[$k]['exhibition_dates4_date'] = "・".date('m/d',strtotime($v['exhibition_dates4']));
                    $info_seminars[$k]['exhibition_dates4_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates4']))];
                }
                if (!empty($v['exhibition_dates5'])){
                    $info_seminars[$k]['exhibition_dates5_date'] = "・".date('m/d',strtotime($v['exhibition_dates5']));
                    $info_seminars[$k]['exhibition_dates5_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates5']))];
                }
                if (!empty($v['exhibition_dates6'])){
                    $info_seminars[$k]['exhibition_dates6_date'] = "・".date('m/d',strtotime($v['exhibition_dates6']));
                    $info_seminars[$k]['exhibition_dates6_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates6']))];
                }
                if (!empty($v['exhibition_dates7'])){
                    $info_seminars[$k]['exhibition_dates7_date'] = "・".date('m/d',strtotime($v['exhibition_dates7']));
                    $info_seminars[$k]['exhibition_dates7_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates7']))];
                }
                if (!empty($v['exhibition_dates8'])){
                    $info_seminars[$k]['exhibition_dates8_date'] = "・".date('m/d',strtotime($v['exhibition_dates8']));
                    $info_seminars[$k]['exhibition_dates8_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates8']))];
                }
                if (!empty($v['exhibition_dates9'])){
                    $info_seminars[$k]['exhibition_dates9_date'] = "・".date('m/d',strtotime($v['exhibition_dates9']));
                    $info_seminars[$k]['exhibition_dates9_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates9']))];
                }
                if (!empty($v['exhibition_dates10'])){
                    $info_seminars[$k]['exhibition_dates10_date'] = "・".date('m/d',strtotime($v['exhibition_dates10']));
                    $info_seminars[$k]['exhibition_dates10_week'] = $daysOfWeek[date('N', strtotime($v['exhibition_dates10']))];
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
                $info_seminars[$k]['SEMINARS_EXHIBITIONS_LABLES_ARR'] = $SEMINARS_EXHIBITIONS_LABLES_ARR;
            }
        }
        $this->data['info_seminars'] = $info_seminars;
        return view('web/seminar/seminar_fix',$this->data);
    }

    public function get_teacher_detail($id)
    {
        $Web = new Web($this);
        //講師Details
        $info_teacher = $Web->web_search_teacher_id_info($id);

        $this->data['info_teacher'] = $info_teacher;

        return view('web/seminar/teacher_detail',$this->data);
    }
}
