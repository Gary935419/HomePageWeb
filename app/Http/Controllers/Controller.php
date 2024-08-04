<?php

namespace App\Http\Controllers;

use App\Models\Logs;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;
    public $data;
    public $Logs;
    public $config;
    public $env;

    public function __construct()
    {
        $this->Logs = new Logs($this);

        $this->data = array(
            'Config' => $this->config,
            'Env' => $this->env
        );
    }
}
