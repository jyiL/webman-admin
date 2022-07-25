<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/25
 * Time: 10:46
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanAdmin\Service;

use Tinywan\Jwt\JwtToken;

class UserService
{
    public static function user()
    {
        return JwtToken::getUser();
    }
}