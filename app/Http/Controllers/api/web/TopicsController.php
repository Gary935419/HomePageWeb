<?php

namespace App\Http\Controllers\api\web;

use App\Models\Web;

class TopicsController extends Controller
{
    public function post_topics_search()
    {
        try {
            $params = request()->all();
            $Web = new Web($this);
            $open_date_def = date('Y-m-d',time());

            //ニュースリリース一覧
            $info_news_first = $Web->web_search_news_first_search($open_date_def,$params['n_type'],$params['open_date']);
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

            $info_news_second = $Web->web_search_news_second_search($open_date_def,$params['n_type'],$params['open_date']);
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

            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。','DATA' => $info_news));
        } catch (\Exception $e) {
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
