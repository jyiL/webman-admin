<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 16:02
 * Email: avril.leo@yahoo.com
 */

use Webman\Route;

use Jyil\WebmanAdmin\Controller\UserController;

Route::group('/api', function () {
    register_route('/user', UserController::class, function ($controller) {
        // 登陸
        Route::post('/login',  [$controller, 'login']);
        Route::post('/login-info',  [$controller, 'getUserInfo']);
        Route::post('/logout',  [$controller, 'logout']);
    });
});