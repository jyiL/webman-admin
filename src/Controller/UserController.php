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
use Jyil\WebmanAdmin\Service\UserService;
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
            return $this->fail(Response::HTTP_UNPROCESSABLE_ENTITY, '', 200);
        }

        $user = $this->model_class::where('username', $username)->first();

        if (!$user || $user['status'] !== $this->model_class::STATUS_YES) {
            return $this->fail(Response::HTTP_NOT_FOUND, '该用户不存在或已被禁用', 200);
        }

        if ($user->password !== passwordHash($password)) {
            return $this->fail(Response::HTTP_UNPROCESSABLE_ENTITY, '密码错误', 200);
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

        return $this->success([
            'token' => $token['access_token'],
        ]);
    }

    /**
     * 获取登陆信息
     */
    public function getUserInfo(Request $request)
    {
        $user = UserService::user()->toArray();
        return $this->success([
            'name' => $user['realname'],
            'avatar' => $user['avatar'],
            'email' => $user['email'],
            'job' => 'frontend',
            'jobName' => '前端艺术家',
            'organization' => 'Frontend',
            'organizationName' => '前端',
            'location' => 'beijing',
            'locationName' => '北京',
            'introduction' => '人潇洒，性温存',
            'personalWebsite' => 'https://www.arco.design',
            'phone' => $user['mobile'],
            'registrationDate' => $user['created_at'],
            'accountId' => '15012312300',
            'certification' => 1,
            'role' => 'admin',
        ]);
    }

    /**
     * 登出
     */
    public function logout(Request $request)
    {
        return $this->success();
    }
}