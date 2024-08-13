<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebTopicsController
{
    public function get_topics_index()
    {
        $paramsAll = request()->all();

        $this->data['n_type'] = 0;
        if (isset($paramsAll['n_type']) && !empty($paramsAll['n_type'])){
            $this->data['n_type'] = $paramsAll['n_type'];
        }

        $this->data['open_date'] = "";
        if (isset($paramsAll['open_date']) && !empty($paramsAll['open_date'])){
            $this->data['open_date'] = $paramsAll['open_date'];
        }

        $Web = new Web($this);
        $open_date_def = date('Y-m-d',time());

        //ニュースリリース一覧
        $info_news_first = $Web->web_search_news_first_search($open_date_def,$this->data['n_type'],$this->data['open_date']);
        $info_news_fixed_arr = array();
        foreach ($info_news_first as $v){
            if(empty($v['fix_open_date']) && empty($v['fix_close_date'])){
                $info_news_fixed_arr[] = $v;
            }
            if (!empty($v['fix_open_date']) && empty($v['fix_close_date'])){
                if ($open_date_def >= date('Y-m-d',strtotime($v['fix_open_date']))){
                    $info_news_fixed_arr[] = $v;
                }
            }
            if (empty($v['fix_open_date']) && !empty($v['fix_close_date'])){
                if ($open_date_def <= date('Y-m-d',strtotime($v['fix_close_date']))){
                    $info_news_fixed_arr[] = $v;
                }
            }
            if (!empty($v['fix_open_date']) && !empty($v['fix_close_date'])){
                if (($open_date_def >= date('Y-m-d',strtotime($v['fix_open_date']))) && ($open_date_def <= date('Y-m-d',strtotime($v['fix_close_date'])))){
                    $info_news_fixed_arr[] = $v;
                }
            }
        }
        usort($info_news_fixed_arr, function($a, $b) {
            return $b['n_open_date'] <=> $a['n_open_date'];
        });

        $info_news_second = $Web->web_search_news_second_search($open_date_def,$this->data['n_type'],$this->data['open_date']);
        $info_news_unfixed_arr = array();
        foreach ($info_news_second as $v){
            if (!empty($v['n_fixed_flg'])){
                if(empty($v['fix_open_date']) && empty($v['fix_close_date'])){
                    continue;
                }
                if (!empty($v['fix_open_date']) && empty($v['fix_close_date'])){
                    if ($open_date_def >= date('Y-m-d',strtotime($v['fix_open_date']))){
                        continue;
                    }
                }
                if (empty($v['fix_open_date']) && !empty($v['fix_close_date'])){
                    if ($open_date_def <= date('Y-m-d',strtotime($v['fix_close_date']))){
                        continue;
                    }
                }
                if (!empty($v['fix_open_date']) && !empty($v['fix_close_date'])){
                    if (($open_date_def >= date('Y-m-d',strtotime($v['fix_open_date']))) && ($open_date_def <= date('Y-m-d',strtotime($v['fix_close_date'])))){
                        continue;
                    }
                }
            }
            $info_news_unfixed_arr[] = $v;
        }
        usort($info_news_unfixed_arr, function($a, $b) {
            return $b['n_open_date'] <=> $a['n_open_date'];
        });
        
        $info_news = array_merge($info_news_fixed_arr, $info_news_unfixed_arr);
        foreach ($info_news as $k=>$v){
            $info_news[$k]['n_open_date'] = date('Y-m-d',strtotime($v['n_open_date']));
            if ($v['n_type'] == 1){
                $info_news[$k]['n_type_name'] = "新着情報";
            }elseif ($v['n_type'] == 2){
                $info_news[$k]['n_type_name'] = "セミナー展示会";
            }elseif ($v['n_type'] == 3){
                $info_news[$k]['n_type_name'] = "ニュースリリース";
            }elseif ($v['n_type'] == 4){
                $info_news[$k]['n_type_name'] = "メディア";
            }else{
                $info_news[$k]['n_type_name'] = "障害連絡";
            }
        }
        $this->data['info_news'] = $info_news;

        $currentYear = array();
        $news_info_yesr = $Web->web_search_news_info_yesr($open_date_def);
        foreach ($news_info_yesr as $k=>$v){
            $Year = date('Y', strtotime($v['n_open_date']));
            if (!in_array($Year,$currentYear)){
                $currentYear[] = $Year;
            }
        }
        $this->data['currentYear'] = $currentYear;
        return view('web/topics/index',$this->data);
    }

    public function get_topics_detail($id)
    {
        $Web = new Web($this);
        //ニュースDetails
        $info_news = $Web->web_search_new_id_info($id);
        if (empty($info_news)){
            return redirect('/');
        }
        $info_news['n_open_date'] = date('Y-m-d',strtotime($info_news['n_open_date']));
        $this->data['info_news'] = $info_news;

        return view('web/topics/detail',$this->data);
    }
}
