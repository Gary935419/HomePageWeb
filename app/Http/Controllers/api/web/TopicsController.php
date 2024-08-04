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
            //ニュースリリース一覧
            $info_news = $Web->web_search_news_info($params['n_type'],$params['open_date']);
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
