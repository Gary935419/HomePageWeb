<?php

namespace App\Models;

class Logs extends Model
{
    private $Lara;
    public $SEQ_NO;

    public function __construct(&$Lara, $is_api=true)
    {
        global $LOG_SEQ_NO;
        $this->Lara = $Lara;

        // 本番環境ではログを出さない（個人情報が出力されてしまうため）
        if ($is_api && config('app.env') != 'production') {
            $data = openssl_random_pseudo_bytes(16);
            $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
            $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
            $uniqueLogKey = vsprintf('%s%s%s%s%s%s%s%s', str_split(bin2hex($data), 4));
            $params = \Input::all();
            $all_header = getallheaders();
            $logData = array(
                'LOG_TYPE' => 1,
                'UNIQUE_KEY' => $uniqueLogKey,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'URI' => $_SERVER['REQUEST_URI'],
                'METHOD' => $_SERVER['REQUEST_METHOD'],
                'HEADER' => json_encode($all_header),
                'REQUEST' => json_encode($params),
                'TYPE' => '',
                'RESPONSE' => '',
                'CREATED_USER' => (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME'],
                'CREATED_DT' => get_now_jst(),
            );

            $logPath = APPPATH . 'logs' . DS . 'request' . DS . date('Y-m') . DS;
            if (!file_exists($logPath)) {
                mkdir($logPath, 0777, true);
            }

            file_put_contents($logPath . date('d') . '.log', implode("\t", $logData) . "\n", FILE_APPEND);
            $this->SEQ_NO = $uniqueLogKey;
            $LOG_SEQ_NO = $this->SEQ_NO;
        }
    }

    /**
     * レスポンスを保存する
     */
    public function log_save($response, $TYPE)
    {
        // 本番環境ではログを出さない（個人情報が出力されてしまうため）
        if (config('app.env') != 'production') {
            $logData = array(
                'LOG_TYPE' => 2,
                'UNIQUE_KEY' => $this->SEQ_NO,
                'IP' => $_SERVER['REMOTE_ADDR'],
                'URI' => $_SERVER['REQUEST_URI'],
                'TYPE' => $TYPE,
                'RESPONSE' =>json_encode($response),
                'CREATED_USER' => (isset($_SERVER['SERVER_ADDR'])) ? $_SERVER['SERVER_ADDR'] : $_SERVER['SERVER_NAME'],
                'CREATED_DT' => get_now_jst(),
            );

            $logPath = APPPATH . 'logs' . DS . 'request' . DS . date('Y-m') . DS;
            if (!file_exists($logPath)) {
                mkdir($logPath, 0777, true);
            }

            file_put_contents($logPath . date('d') . '.log', implode("\t", $logData) . "\n", FILE_APPEND);
            return true;
        }
        return true;
    }
}
