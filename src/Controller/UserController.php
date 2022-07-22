<?php
declare(strict_types=1);

/**
 * Author: laijianyi.
 * Date: 2022/7/22
 * Time: 14:51
 * Email: avril.leo@yahoo.com
 */

namespace Jyil\WebmanAdmin\Controller;

use Carbon\Carbon;
use Jyil\WebmanBaseUtils\Controller\AbstractController;
use Jyil\WebmanAdmin\Model\User;
use support\Request;
use Symfony\Component\HttpFoundation\Response;
use Tinywan\Jwt\JwtToken;

class UserController extends AbstractController
{
    protected $model_class = User::class;

    /**
     * 登陸
     */
    public function login(Request $request)
    {
        $username = $request->input('username', '');
        $password = $request->input('password', '');

        if (!$username || !$password) {
            return $this->fail(Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = $this->model_class::where('username', $username)->first();

        if (!$user || $user['status'] !== $this->model_class::STATUS_YES) {
            return $this->fail(Response::HTTP_NOT_FOUND, '该用户不存在或已被禁用');
        }

        if ($user->password !== passwordHash($password)) {
            return $this->fail(Response::HTTP_UNPROCESSABLE_ENTITY, '密码错误');
        }

        $data = [
            'id' => $user->id,
            'iat' => Carbon::now()->timestamp,
            'exp' => Carbon::now()->addDay()->timestamp,
            'user_info' => [
                'name' => $user->username,
                'alias_name' => $user->realname,
                'email' => '',
                'avatar' => $user->avatar,
                'mobile' => $user->mobile,
            ],
        ];
        $token = JwtToken::generateToken($data);

        var_dump($token);

        return $this->success([
            'token' => $token,
        ]);
    }
}