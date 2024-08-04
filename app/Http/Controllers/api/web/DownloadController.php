<?php

namespace App\Http\Controllers\api\web;

use App\Models\Web;
use Illuminate\Support\Facades\DB;


class DownloadController extends Controller
{
    public function post_download_from_add()
    {
        try {
            $params = request()->all();
            $Web = new Web($this);
            //ダウンロード
            $info_download = $Web->web_search_downloads_id_info($params['id']);
            if (empty($info_download)){
                return $this->ok(array('RESULT' => 'NG', 'MESSAGE' => 'ダウンロードデータエラー'));
            }

            //ダウンロード履歴 add
            //数据库事务处理
            DB::beginTransaction();

            $insert_S_DOWNLOADS_HISTORY = array();
            $insert_S_DOWNLOADS_HISTORY['d_id'] = $params['id'];
            $insert_S_DOWNLOADS_HISTORY['d_file_url'] = $info_download['d_file_url'];
            $insert_S_DOWNLOADS_HISTORY['d_file_name'] = $info_download['d_file_name'];
            $insert_S_DOWNLOADS_HISTORY['user_name'] = $params['user_name'];
            $insert_S_DOWNLOADS_HISTORY['company_name'] = $params['company_name'];
            $insert_S_DOWNLOADS_HISTORY['phone_number'] = $params['phone_number'];
            $insert_S_DOWNLOADS_HISTORY['email'] = $params['email'];
            $insert_S_DOWNLOADS_HISTORY['agreement_flg'] = $params['agreement_flg'];
            $insert_S_DOWNLOADS_HISTORY['CREATED_DT'] = date('Y-m-d',time());
            $insert_S_DOWNLOADS_HISTORY['CREATED_USER'] = session('USER_ID');
            $insert_S_DOWNLOADS_HISTORY['is_del'] = 0;
            $Web->insert_S_DOWNLOADS_HISTORY($insert_S_DOWNLOADS_HISTORY);

            DB::commit();
            return $this->ok(array('RESULT' => 'OK', 'MESSAGE' => 'SUCCESS。'));
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error(array('RESULT' => 'NG', 'MESSAGE' => 'ERROR。<br>' . $e->getMessage() ));
        }
    }
}
