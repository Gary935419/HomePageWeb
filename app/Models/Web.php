<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Web extends Model
{
    private $Lara;

    public function __construct(&$Lara)
    {
        $this->Lara = $Lara;
    }

    public function web_search_news($params)
    {
        try {
            $open_date_def = $params['open_date_def'];
            $query = DB::table('S_NEWS')->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->whereDate('n_open_date','<=',$params['open_date_def']);

            if (!empty($params['n_important_flg'])) {
                $query = $query->where('n_important_flg','=',1);
            }

            $query = $query->where(function ($query) use ($open_date_def) {
                $query->whereDate('n_close_date', '>=', $open_date_def)
                    ->orWhere('n_close_date', '=', "");
            });

            $S_NEWS_result = $query->orderBy('sort')->get()->toArray();

            if (!empty($S_NEWS_result)){
                foreach ($S_NEWS_result as $k=>$v){
                    $originalString = $v['n_contents'];
                    $S_NEWS_result[$k]['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }

            return $S_NEWS_result;

        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_product_banners()
    {
        try {
            $query = DB::table('S_PRODUCT_BANNERS');
            $S_PRODUCT_BANNERS_result = $query->where('is_del', '=', 0)
                ->where('b_flg', '=', 1)
                ->orderBy('sort')
                ->get()->toArray();
            if (!empty($S_PRODUCT_BANNERS_result)){
                foreach ($S_PRODUCT_BANNERS_result as $k=>$v){
                    $S_PRODUCT_BANNERS_result[$k]['b_url'] = config('config.admin_url') . $v['b_url'];
                }
            }
            return $S_PRODUCT_BANNERS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_company_count()
    {
        try {
            $query = DB::table('S_COMPANY')
                ->select(DB::raw('count(*) as count'))
                ->where('is_del', '=', 0)
                ->where('open_flg', '=', 1);
            $all_page_count = $query->value('count');

            return $all_page_count;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_company()
    {
        try {
            $query = DB::table('S_COMPANY');

            $fieldStrHiragana = implode(',', array_map(function($char_hiragana) {
                return "'$char_hiragana'";
            }, config('const.hiragana')));

            $fieldStrKatakana = implode(',', array_map(function($char_katakana) {
                return "'$char_katakana'";
            }, config('const.katakana')));

            $S_COMPANY_result = $query->where('is_del', '=', 0)
                ->where('open_flg', '=', 1)
                ->orderByRaw("
                    CASE
                        WHEN SUBSTRING(furigana_name, 1, 1) IN ($fieldStrHiragana) THEN FIELD(SUBSTRING(furigana_name, 1, 1), $fieldStrHiragana)
                        WHEN SUBSTRING(furigana_name, 1, 1) IN ($fieldStrKatakana) THEN FIELD(SUBSTRING(furigana_name, 1, 1), $fieldStrKatakana)
                        ELSE 9999
                    END
                ")
                ->get()->toArray();

            if (!empty($S_COMPANY_result)){
                foreach ($S_COMPANY_result as $k=>$v){
                    $S_COMPANY_result[$k]['logo_url'] = config('config.admin_url') . $v['logo_url'];
                }
            }
            return $S_COMPANY_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_seminars_exhibitions($category,$date,$close_flg = 0)
    {
        try {
            $query = DB::table('S_SEMINARS_EXHIBITIONS')
                ->where('is_del', '=', 0)
                ->where('open_flg', '=', 1);

            if (!empty($category)){
                $query = $query->where('category', '=', $category);
            }

            if ($close_flg == 1){
                $query = $query->where(function ($query) use ($date) {
                    $query->where('exhibition_dates1', '<', $date)
                        ->where('exhibition_dates2', '<', $date)
                        ->where('exhibition_dates3', '<', $date)
                        ->where('exhibition_dates4', '<', $date)
                        ->where('exhibition_dates5', '<', $date)
                        ->where('exhibition_dates6', '<', $date)
                        ->where('exhibition_dates7', '<', $date)
                        ->where('exhibition_dates8', '<', $date)
                        ->where('exhibition_dates9', '<', $date)
                        ->where('exhibition_dates10', '<', $date);
                });
            }else{
                $query = $query->where(function ($query) use ($date) {
                    $query->where('exhibition_dates1', '>=', $date)
                        ->orWhere('exhibition_dates2', '>=', $date)
                        ->orWhere('exhibition_dates3', '>=', $date)
                        ->orWhere('exhibition_dates4', '>=', $date)
                        ->orWhere('exhibition_dates5', '>=', $date)
                        ->orWhere('exhibition_dates6', '>=', $date)
                        ->orWhere('exhibition_dates7', '>=', $date)
                        ->orWhere('exhibition_dates8', '>=', $date)
                        ->orWhere('exhibition_dates9', '>=', $date)
                        ->orWhere('exhibition_dates10', '>=', $date);
                });
            }
            $S_SEMINARS_EXHIBITIONS_result = $query->orderBy('sort')->get()->toArray();
            if (!empty($S_SEMINARS_EXHIBITIONS_result)){
                foreach ($S_SEMINARS_EXHIBITIONS_result as $k=>$v){
                    $S_SEMINARS_EXHIBITIONS_result[$k]['b_url'] = config('config.admin_url') . $v['b_url'];
                }
            }
            return $S_SEMINARS_EXHIBITIONS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_SEMINARS_EXHIBITIONS_LABLES_ID_info($id)
    {
        try {
            return DB::table('S_SEMINARS_EXHIBITIONS_LABLES')
                ->where('is_del', '=', 0)
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_product_lables()
    {
        try {
            $query = DB::table('S_PRODUCT_LABLES');
            $S_PRODUCT_LABLES_result = $query->where('is_del', '=', 0)
                ->orderBy('sort')
                ->get()->toArray();
            return $S_PRODUCT_LABLES_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_product($lables_arr)
    {
        try {
            $query = DB::table('S_PRODUCT_INFORMATION')
                ->where('is_del', '=', 0)
                ->where('p_open_flg', '=', 1);
            if (!empty($lables_arr)) {
                $query = $query->where(function ($query) use ($lables_arr) {
                    foreach ($lables_arr as $k=>$v){
                        if ($k == 0){
                            $query->whereRaw("FIND_IN_SET(?, p_lables)", $v);
                        }else{
                            $query->orWhereRaw("FIND_IN_SET(?, p_lables)", $v);
                        }
                    }
                });
            }
            $S_PRODUCT_LABLES_result = $query->orderBy('sort')->get()->toArray();
            if (!empty($S_PRODUCT_LABLES_result)){
                foreach ($S_PRODUCT_LABLES_result as $k=>$v){
                    $S_PRODUCT_LABLES_result[$k]['p_logo'] = config('config.admin_url') . $v['p_logo'];
                    $S_PRODUCT_LABLES_result[$k]['p_main_img'] = config('config.admin_url') . $v['p_main_img'];
                    $S_PRODUCT_LABLES_result[$k]['p_pdf_url'] = config('config.admin_url') . $v['p_pdf_url'];
                }
            }
            return $S_PRODUCT_LABLES_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_product_lables_id_info($id)
    {
        try {
            return DB::table('S_PRODUCT_LABLES')
                ->where('is_del', '=', 0)
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_precedents()
    {
        try {
            $query = DB::table('S_PRECEDENTS');
            $result = $query->where('is_del', '=', 0)
                ->where('open_flg', '=', 1)
                ->orderBy('sort')
                ->get()->toArray();
            if (!empty($result)){
                foreach ($result as $k=>$v){
                    $result[$k]['pr_img_url'] = config('config.admin_url') . $v['pr_img_url'];
                    $result[$k]['guild_logo'] = config('config.admin_url') . $v['guild_logo'];
                    $result[$k]['main_img_url'] = config('config.admin_url') . $v['main_img_url'];
                    $originalString = $v['pr_contents'];
                    $result[$k]['pr_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_prodect_lables($p_type)
    {
        try {
            $query = DB::table('S_PRODECT_LABLES');
            $result = $query->where('is_del', '=', 0)
                ->where('p_type', '=', $p_type)
                ->orderBy('sort')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_company_by_lables($p_type_arr)
    {
        try {
            $query = DB::table('S_COMPANY');
            if (!empty($p_type_arr)) {
                $query = $query->where(function ($query) use ($p_type_arr) {
                    foreach ($p_type_arr as $k=>$v){
                        if ($k == 0){
                            $query->whereRaw("FIND_IN_SET(?, c_lables)", [$v]);
                        }else{
                            $query->orWhereRaw("FIND_IN_SET(?, c_lables)", [$v]);
                        }
                    }
                });
            }
            $fieldStrHiragana = implode(',', array_map(function($char_hiragana) {
                return "'$char_hiragana'";
            }, config('const.hiragana')));

            $fieldStrKatakana = implode(',', array_map(function($char_katakana) {
                return "'$char_katakana'";
            }, config('const.katakana')));

            $S_COMPANY_result = $query->where('is_del', '=', 0)
                ->where('open_flg', '=', 1)
                ->orderByRaw("
                    CASE
                        WHEN SUBSTRING(furigana_name, 1, 1) IN ($fieldStrHiragana) THEN FIELD(SUBSTRING(furigana_name, 1, 1), $fieldStrHiragana)
                        WHEN SUBSTRING(furigana_name, 1, 1) IN ($fieldStrKatakana) THEN FIELD(SUBSTRING(furigana_name, 1, 1), $fieldStrKatakana)
                        ELSE 9999
                    END
                ")
                ->get()->toArray();
            if (!empty($S_COMPANY_result)){
                foreach ($S_COMPANY_result as $k=>$v){
                    $S_COMPANY_result[$k]['logo_url'] = config('config.admin_url') . $v['logo_url'];
                }
            }
            return $S_COMPANY_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_prodect_lables_id_info($id)
    {
        try {
            $result = DB::table('S_PRODECT_LABLES')
                ->where('is_del', '=', 0)
                ->where('id','=',$id)
                ->first();
            return $result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_precedents_id_info($id)
    {
        try {
            $result = DB::table('S_PRECEDENTS')
                ->where('id','=',$id)
                ->where('is_del','=',0)
                ->first();
            if (!empty($result)){
                $result['pr_img_url'] = config('config.admin_url') . $result['pr_img_url'];
                $result['main_img_url'] = config('config.admin_url') . $result['main_img_url'];
                $result['guild_logo'] = config('config.admin_url') . $result['guild_logo'];
                $originalString = $result['pr_contents'];
                $result['pr_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
            }
            return $result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_precedents_id_info_before_after($id,$select_type)
    {
        try {
            $query = DB::table('S_PRECEDENTS')
                ->where('is_del', '=', 0);
            if ($select_type == 1){
                $query = $query->where('id','<',$id)->orderBy('id','DESC');
            }else{
                $query = $query->where('id','>',$id);
            }
            $S_PRECEDENTS_result = $query->first();
            if (!empty($S_PRECEDENTS_result)){
                $S_PRECEDENTS_result['pr_img_url'] = config('config.admin_url') . $S_PRECEDENTS_result['pr_img_url'];
                $S_PRECEDENTS_result['main_img_url'] = config('config.admin_url') . $S_PRECEDENTS_result['main_img_url'];
                $S_PRECEDENTS_result['guild_logo'] = config('config.admin_url') . $S_PRECEDENTS_result['guild_logo'];
                $originalString = $S_PRECEDENTS_result['pr_contents'];
                $S_PRECEDENTS_result['pr_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
            }
            return $S_PRECEDENTS_result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_news_info_yesr($open_date_def)
    {
        try {
            $query = DB::table('S_NEWS')->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->whereDate('n_open_date','<=',$open_date_def);

            $query = $query->where(function ($query) use ($open_date_def) {
                $query->whereDate('n_close_date', '>=', $open_date_def)
                    ->orWhere('n_close_date', '=', "");
            });
            $S_NEWS_result = $query->get()->toArray();

            if (!empty($S_NEWS_result)){
                foreach ($S_NEWS_result as $k=>$v){
                    $originalString = $v['n_contents'];
                    $S_NEWS_result[$k]['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }

            return $S_NEWS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_new_id_info($id)
    {
        try {
            $S_NEWS_result = DB::table('S_NEWS')
                ->where('id','=',$id)
                ->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->first();
            if (!empty($S_NEWS_result)){
                $originalString = $S_NEWS_result['n_contents'];
                $S_NEWS_result['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
            }
            return $S_NEWS_result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_teacher()
    {
        try {
            $query = DB::table('S_TEACHER');

            $S_TEACHER_result = $query->where('is_del', '=', 0)
                ->orderBy('sort')
                ->get()->toArray();
            if (!empty($S_TEACHER_result)){
                foreach ($S_TEACHER_result as $k=>$v){
                    $S_TEACHER_result[$k]['b_url'] = config('config.admin_url') . $v['b_url'];
                }
            }
            return $S_TEACHER_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_teacher_id_info($id)
    {
        try {
            $result = DB::table('S_TEACHER')
                ->where('id','=',$id)
                ->where('is_del','=',0)
                ->first();
            if (!empty($result)){
                $result['b_url'] = config('config.admin_url') . $result['b_url'];
            }
            return $result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_seminars_exhibitions_close_all_page($date)
    {
        try {
            $query = DB::table('S_SEMINARS_EXHIBITIONS')
                ->select(DB::raw('count(*) as count'))
                ->where('is_del', '=', 0)
                ->where('open_flg', '=', 1);

            $query = $query->where(function ($query) use ($date) {
                $query->where('exhibition_dates1', '<', $date)
                    ->where('exhibition_dates2', '<', $date)
                    ->where('exhibition_dates3', '<', $date)
                    ->where('exhibition_dates4', '<', $date)
                    ->where('exhibition_dates5', '<', $date)
                    ->where('exhibition_dates6', '<', $date)
                    ->where('exhibition_dates7', '<', $date)
                    ->where('exhibition_dates8', '<', $date)
                    ->where('exhibition_dates9', '<', $date)
                    ->where('exhibition_dates10', '<', $date);
            });
            $all_page_count = $query->value('count');

            return ceil($all_page_count / 6) == 0 ? 1 : ceil($all_page_count / 6);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_seminars_exhibitions_close_all($date,$page)
    {
        try {
            $query = DB::table('S_SEMINARS_EXHIBITIONS')
                ->where('is_del', '=', 0)
                ->where('open_flg', '=', 1);

            $query = $query->where(function ($query) use ($date) {
                $query->where('exhibition_dates1', '<', $date)
                    ->where('exhibition_dates2', '<', $date)
                    ->where('exhibition_dates3', '<', $date)
                    ->where('exhibition_dates4', '<', $date)
                    ->where('exhibition_dates5', '<', $date)
                    ->where('exhibition_dates6', '<', $date)
                    ->where('exhibition_dates7', '<', $date)
                    ->where('exhibition_dates8', '<', $date)
                    ->where('exhibition_dates9', '<', $date)
                    ->where('exhibition_dates10', '<', $date);
            });
            $start = ($page - 1) * 6;
            $stop = 6;
            $S_SEMINARS_EXHIBITIONS_result = $query->orderBy('sort')->offset($start)->limit($stop)->get()->toArray();
            if (!empty($S_SEMINARS_EXHIBITIONS_result)){
                foreach ($S_SEMINARS_EXHIBITIONS_result as $k=>$v){
                    $S_SEMINARS_EXHIBITIONS_result[$k]['b_url'] = config('config.admin_url') . $v['b_url'];
                }
            }
            return $S_SEMINARS_EXHIBITIONS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_downloads_category()
    {
        try {
            $query = DB::table('S_DOWNLOADS_CATEGORY');
            $result = $query->where('is_del', '=', 0)
                ->where('open_flg', '=', 1)
                ->orderBy('sort')
                ->get()->toArray();
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_category_downloads_arr($id)
    {
        try {
            $query = DB::table('S_DOWNLOADS');
            $result = $query->where('is_del', '=', 0)
                ->where('open_flg', '=', 1)
                ->whereRaw("FIND_IN_SET(?, d_category)", [$id])
                ->orderBy('sort')
                ->get()->toArray();
            if (!empty($result)){
                foreach ($result as $k=>$v){
                    $result[$k]['d_file_url'] = config('config.admin_url') . $v['d_file_url'];
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_downloads_id_info($id)
    {
        try {
            $result = DB::table('S_DOWNLOADS')
                ->where('id','=',$id)
                ->where('is_del','=',0)
                ->where('open_flg','=',1)
                ->first();
            if (!empty($result)){
                $result['d_file_url'] = config('config.admin_url') . $result['d_file_url'];
            }
            return $result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function insert_S_DOWNLOADS_HISTORY($insert_S_DOWNLOADS_HISTORY)
    {
        return DB::table('S_DOWNLOADS_HISTORY')->insertGetId($insert_S_DOWNLOADS_HISTORY);
    }

    public function web_search_downloads_history_id_info($id,$phone_number,$email,$d_type = 0)
    {
        try {
            $result = DB::table('S_DOWNLOADS_HISTORY')
                ->where('d_id','=',$id)
                ->where('phone_number','=',$phone_number)
                ->where('email','=',$email)
                ->where('is_del','=',0)
                ->where('d_type','=',$d_type)
                ->first();
            if (!empty($result)){
                $result['d_file_url'] = config('config.admin_url') . $result['d_file_url'];
            }
            return $result;
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_management_site()
    {
        try {
            $query = DB::table('S_MANAGEMENT_SITE');
            $result = $query->where('is_del', '=', 0)
                ->where('open_flg', '=', 1)
                ->orderBy('sort')
                ->get()->toArray();
            if (!empty($result)){
                foreach ($result as $k=>$v){
                    $result[$k]['logo'] = config('config.admin_url') . $v['logo'];
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function select_S_PRODUCT_INFORMATION_ID_info($id)
    {
        try {
            return DB::table('S_PRODUCT_INFORMATION')
                ->where('id','=',$id)
                ->first();
        } catch(\Exception $e) {
            throw $e;
        }
    }

    public function web_search_news_first($open_date_def)
    {
        try {
            $query = DB::table('S_NEWS')->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->where('n_fixed_flg', '=', 1)
                ->whereDate('n_open_date','<=',$open_date_def);

            $query = $query->where(function ($query) use ($open_date_def) {
                $query->whereDate('n_close_date', '>=', $open_date_def)
                    ->orWhere('n_close_date', '=', "");
            });
            $S_NEWS_result = $query->get()->toArray();

            if (!empty($S_NEWS_result)){
                foreach ($S_NEWS_result as $k=>$v){
                    $originalString = $v['n_contents'];
                    $S_NEWS_result[$k]['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }

            return $S_NEWS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_news_second($open_date_def)
    {
        try {
            $query = DB::table('S_NEWS')->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->whereDate('n_open_date','<=',$open_date_def);

            $query = $query->where(function ($query) use ($open_date_def) {
                $query->whereDate('n_close_date', '>=', $open_date_def)
                    ->orWhere('n_close_date', '=', "");
            });
            $S_NEWS_result = $query->get()->toArray();

            if (!empty($S_NEWS_result)){
                foreach ($S_NEWS_result as $k=>$v){
                    $originalString = $v['n_contents'];
                    $S_NEWS_result[$k]['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }

            return $S_NEWS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_news_first_search($open_date_def,$n_type,$open_date_year)
    {
        try {
            $query = DB::table('S_NEWS')->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->where('n_fixed_flg', '=', 1)
                ->whereDate('n_open_date','<=',$open_date_def);

            if (!empty($n_type)) {
                $query = $query->where('n_type','=',$n_type);
            }

            if (!empty($open_date_year)) {
                $query = $query->whereYear('n_open_date','=',$open_date_year);
            }else{
                $query = $query->whereYear('n_open_date','<=',$open_date_def);
            }

            $query = $query->where(function ($query) use ($open_date_def) {
                $query->whereDate('n_close_date', '>=', $open_date_def)
                    ->orWhere('n_close_date', '=', "");
            });
            $S_NEWS_result = $query->get()->toArray();

            if (!empty($S_NEWS_result)){
                foreach ($S_NEWS_result as $k=>$v){
                    $originalString = $v['n_contents'];
                    $S_NEWS_result[$k]['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }

            return $S_NEWS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function web_search_news_second_search($open_date_def,$n_type,$open_date_year)
    {
        try {
            $query = DB::table('S_NEWS')->where('is_del', '=', 0)
                ->where('n_open_flg', '=', 1)
                ->whereDate('n_open_date','<=',$open_date_def);

            if (!empty($n_type)) {
                $query = $query->where('n_type','=',$n_type);
            }

            if (!empty($open_date_year)) {
                $query = $query->whereYear('n_open_date','=',$open_date_year);
            }else{
                $query = $query->whereYear('n_open_date','<=',$open_date_def);
            }

            $query = $query->where(function ($query) use ($open_date_def) {
                $query->whereDate('n_close_date', '>=', $open_date_def)
                    ->orWhere('n_close_date', '=', "");
            });
            $S_NEWS_result = $query->get()->toArray();

            if (!empty($S_NEWS_result)){
                foreach ($S_NEWS_result as $k=>$v){
                    $originalString = $v['n_contents'];
                    $S_NEWS_result[$k]['n_contents'] = str_replace("/uploads/", config('config.admin_url') . "/uploads/", $originalString);
                }
            }

            return $S_NEWS_result;
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
