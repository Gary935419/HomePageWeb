<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel
{
    /**
     * 必須チェック
     *
     * @param array $params   パラメータ
     * @param array $requires 必須項目のキー
     */
    public function params_check($params = array(), $requires = array())
    {
        foreach ($requires as $require) {
            if (!isset($params[$require]) || $params[$require] == '') {
                throw new \OneException(4, "Missing : {$require}");
            }
        }
        return true;
    }

}
