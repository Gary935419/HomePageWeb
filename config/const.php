<?php

return array(
    // sha1 の salt
    'PASSWORD_SALT' => 'v1JquxVG1D4MAOZdo3iFS2CGV',
    //ユーザーパスワード有効期間
    'USER_PASSWORD_VALID_PERIOD' => 90 * 24 * 3600,
    // パスワード最小有効桁数
    'PASSWORD_LIMI_MINLENGTH_ADMIN' => 8,
    // パスワード最大有効桁数
    'PASSWORD_LIMI_MAXLENGTH_ADMIN' => 12,
    // パスワード有効文字列
    'PASSWORD_VALIDATE_STRING_ADMIN' => '/[^a-zA-Z0-9]/',
    // パスワード有効文字列数字
    'PASSWORD_VALIDATE_NUMBER_ADMIN' => '/[0-9]/',
    // パスワード有効文字列英字
    'PASSWORD_VALIDATE_ALPHABET_ADMIN' => '/[a-zA-Z]/',
    // パスワード有効文字列記号
    'PASSWORD_VALIDATE_SIGN_ADMIN' => '/[@%+\\|\/\'!#:.(){}[\]~\-_^]/',
    // パスワード数字必須
    'PASSWORD_REQUIRE_NUMBER_ADMIN' => true,
    // パスワード英字必須
    'PASSWORD_REQUIRE_ALPHABET_ADMIN' => true,
    // パスワード記号必須
    'PASSWORD_REQUIRE_SIGN_ADMIN' => false,
    // パスワード有効文字列
    'USER_ID_VALIDATE_STRING_ADMIN' => '/[^a-zA-Z0-9_\-\s]/',

);
