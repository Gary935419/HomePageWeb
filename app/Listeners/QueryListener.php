<?php

namespace App\Listeners;

use Illuminate\Database\Events\QueryExecuted;

class QueryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Database\Events\QueryExecuted  $event
     * @return void
     */
    public function handle(QueryExecuted $event)
    {
        // 開発環境のみlogにSQL文をDebug出力
        if (config('app.env') == 'development') {
            $toSQL = array_reduce($event->bindings, function ($sql, $binding) {
                return preg_replace('/\?/', is_numeric($binding) ? $binding : "'".$binding."'", $sql, 1);
            }, $event->sql);

            $backTrace = debug_backtrace(2);

            $funcInfo = $ParentInfo = '';
            $found = false;
            foreach ($backTrace as $backtrace) {
                if (!$found && isset($backtrace['file']) && false !== strpos($backtrace['file'], '/Models/')) {
                    $ParentInfo = basename($backtrace['file']).':'.$backtrace['line'];
                    $found = true;
                    continue;
                }
                if ($found && isset($backtrace['file'])) {
                    $funcInfo = basename($backtrace['file']).':'.$backtrace['line'].'--'.$ParentInfo."@".$backtrace['function'];
                    break;
                }
            }

            logger($funcInfo);
            logger($toSQL);
        }
    }
}
