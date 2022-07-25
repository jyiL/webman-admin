<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 18:03
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanAdmin\Middleware;

use Webman\MiddlewareInterface;
use Webman\Http\Response;
use Webman\Http\Request;
use Tinywan\Jwt\JwtToken;

class AuthMiddleware implements MiddlewareInterface
{
    private $whitelist = [
        '/api/user/login',
        '/api/user/logout'
    ];

    public function process(Request $request, callable $handler) : Response
    {
        if (!in_array($request->path(), $this->whitelist)) {
            JwtToken::verify();
        }

        return $handler($request);
    }
}