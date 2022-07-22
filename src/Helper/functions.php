<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 15:34
 * Email: avril.leo@yahoo.com
 */

if (!function_exists('passwordHash')) {
    function passwordHash(string $password)
    {
        return sha1(md5($password) . md5(config('plugin.jyil.webman-admin.app.password.salt')));
    }
}