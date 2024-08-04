<?php

namespace App\Http\Controllers\api\web;

use App\Models\APIEncryption;
use App\Models\Logs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    public $data;
    public $Logs;
    public $Errors;
    public $config;
    public $env;

    public function __construct()
    {
        try {
            $this->config = config('const');
            $this->Logs = new Logs($this);
            $this->data = array(
                'Config' => $this->config
            );
        } catch (\Exception $e) {
            Log::error(__CLASS__.":".__FUNCTION__.":".__LINE__);
            Log::error($e->getMessage());
        }
    }

    /**
     * APIの正常系レスポンスを返す
     */
    public function ok($DATA = null, $force = false)
    {
        $response = array(
            'STATUS' => 0
        );

        if ($DATA != null) {
            $response = array_merge($DATA, $response);
        }

        if (!$force) {
            return $response;
        } else {
            echo json_encode($response);
            exit();
        }
    }

    /**
     * APIのエラーレスポンスを返す
     */
    public function error($MESSAGES, $force = false)
    {
        if (is_string($MESSAGES)) {
            $MESSAGES = array($MESSAGES);
        }
        if (!is_array($MESSAGES)) {
            $MESSAGES = array();
        }

        $MESSAGE_ARRAY = array();

        if (sizeof($MESSAGES) > 0 && is_array($MESSAGES[0])) {
            foreach ($MESSAGES as $MESSAGE_SUB) {
                foreach ($MESSAGE_SUB as $MESSAGE) {
                    $MESSAGE_ARRAY[] = array(
                        'MESSAGE' => $MESSAGE
                    );
                }
            }
        } else {
            foreach ($MESSAGES as $MESSAGE) {
                $MESSAGE_ARRAY[] = array(
                    'MESSAGE' => $MESSAGE
                );
            }
        }

        $response = array(
            'STATUS' => 1,
            'MESSAGE_ARRAY' => $MESSAGE_ARRAY
        );
        $this->Logs->log_save($response, 'error');
        if (!$force) {
            return $response;
        } else {
            echo json_encode($response);
            exit();
        }
    }

}
