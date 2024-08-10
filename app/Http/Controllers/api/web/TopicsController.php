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
            $info_news_first = $Web->web_search_news_first();
            foreach ($info_news_first as $k=>$v){
                $info_news_first[$k]['n_open_date'] = date('Y-m-d',strtotime($v['n_open_date']));
                if ($v['n_type'] == 1){
                    $info_news_first[$k]['n_type_name'] = "新着情報";
                }elseif ($v['n_type'] == 2){
                    $info_news_first[$k]['n_type_name'] = "セミナー展示会";
                }elseif ($v['n_type'] == 3){
                    $info_news_first[$k]['n_type_name'] = "ニュースリリース";
                }elseif ($v['n_type'] == 4){
                    $info_news_first[$k]['n_type_name'] = "メディア";
                }else{
                    $info_news_first[$k]['n_type_name'] = "障害連絡";
                }
                $info_news_first[$k]['date_sort'] = "";
            }

            $info_news = $Web->web_search_news_info($params['n_type'],$params['open_date'],$open_date_def);
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
                $info_news[$k]['date_sort'] = date('Y-m-d',strtotime($v['n_open_date']));
                if ($v['n_fixed_flg'] == 1){
                    if (!empty($v['fix_open_date']) && empty($v['fix_close_date'])){
                        $info_news[$k]['date_sort'] = date('Y-m-d',strtotime($v['fix_open_date']));
//                        if (time() > strtotime($v['fix_open_date'])){
//                            $info_news[$k]['n_open_date'] = date('Y-m-d',strtotime($v['fix_open_date']));
//                        }
                    }elseif (empty($v['fix_open_date']) && !empty($v['fix_close_date'])){
                        $info_news[$k]['date_sort'] = date('Y-m-d',strtotime('-1 day', strtotime($v['fix_close_date'])));
//                        if (time() > strtotime($v['fix_close_date'])){
//                            $info_news[$k]['n_open_date'] = date('Y-m-d',strtotime('-1 day', strtotime($v['fix_close_date'])));
//                        }
                    }elseif (!empty($v['fix_open_date']) && !empty($v['fix_close_date'])){
                        $info_news[$k]['date_sort'] = date('Y-m-d',strtotime($v['fix_open_date']));
//                        if (time() > strtotime($v['fix_open_date'])){
//                            $info_news[$k]['n_open_date'] = date('Y-m-d',strtotime($v['fix_open_date']));
//                        }
                    }else{
                        unset($info_news[$k]);
                    }
                }
            }

            usort($info_news, function($a, $b) {
                return $b['date_sort'] <=> $a['date_sort'];
            });

            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。','DATA' => array_merge($info_news_first, $info_news)));
        } catch (\Exception $e) {
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
