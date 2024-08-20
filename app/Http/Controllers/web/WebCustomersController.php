<?php

namespace App\Http\Controllers\web;

use App\Models\Web;

class WebCustomersController
{
    public function get_customers_index()
    {
        $p_type_arr = array();
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
        if (empty($info_precedents)){
            return redirect('/');
        }
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

        // <a>タグに変換
        $pattern = '/(https?:\/\/[^\s]+)/';
        $text = $info_precedents['guild_descriptions'];
        $text = preg_replace_callback($pattern, function($matches) {
            $url = $matches[0];
            return '<a href="' . $url . '" target="_blank">' . $url . '</a>';
        }, $text);
        $info_precedents['guild_descriptions'] = $text;


        // YoutubeのURL変換
        if (!empty($info_precedents['main_flg'])){
            $info_precedents['main_video_url'] = self::youtubeUrlToEmbed($info_precedents['main_video_url']);
        }

        $this->data['info_precedents'] = $info_precedents;

        //事例Details Before
        $this->data['before_id'] = "";
        $info_precedents_before_after = $Web->web_search_precedents_id_info_before_after($id,1);
        if (!empty($info_precedents_before_after)){
            $this->data['before_id'] = $info_precedents_before_after['id'];
        }
        //事例Details After
        $this->data['after_id'] = "";
        $info_precedents_before_after = $Web->web_search_precedents_id_info_before_after($id,2);
        if (!empty($info_precedents_before_after)){
            $this->data['after_id'] = $info_precedents_before_after['id'];
        }

        return view('web/customers/detail',$this->data);
    }

    // YoutubeのURL変換
    function youtubeUrlToEmbed($url) {
        // YouTubeの通常URLから動画IDを取得
        if (strpos($url, 'youtube.com/watch?v=') !== false) {
            $urlParts = parse_url($url);
            parse_str($urlParts['query'], $queryParams);
            $videoId = $queryParams['v'];
        }
        // YouTubeの短縮URLから動画IDを取得
        elseif (strpos($url, 'youtu.be/') !== false) {
            $videoId = str_replace('youtu.be/', '', parse_url($url, PHP_URL_PATH));
        } else {
            return 'Invalid YouTube URL';
        }

        // 埋め込みタグを生成
        $embedUrl = "https://www.youtube.com/embed/" . $videoId;

        return $embedUrl;
    }
}
