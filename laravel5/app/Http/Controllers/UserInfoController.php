<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\UserApi;
use App\Http\Controllers\Api\UserInfoApi;
use Illuminate\Support\Facades\Input;

class UserInfoController extends Controller
{

    // http://localhost:8888/test
    public function test()
    {
        $arr = UserApi::create()->all();
        return response(json_encode($arr));

    }



    /**
     * 功能：获取所有信息
     * 响应请求 方法 GET
     * http://localhost:8888/api/admin/login
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function all()
    {
        $arr = UserInfoApi::create()->all();

        return response(json_encode($arr));
    }

    /**
     * 功能：验证用户名和密码是否正确
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/admin/verify/login
     */
    public function verifyLogin()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $data = [
            'userName'=>$username,
            'loginPassword'=>$password
        ];
        $arr = UserInfoApi::create()->verifyLogin($data);

        return response()->json($arr, 200);
    }


    /**
     * 功能：验证用户名是否已存在
     * @param $userName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/admin/verify/user/admin
     */
    public function isUserNameExist($userName)
    {
        $arr = UserInfoApi::create()->isUserNameExist($userName);

        return response(json_encode($arr), JSON_UNESCAPED_UNICODE);
    }

    /**
     * 功能：注册用户
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/admin/register/user
     * http://localhost:8888/ajaxPost
     */
    public function registerUser()
    {
        $userName = Input::get('username');
        $password = Input::get('password');
        $data = [
            'userName'=>$userName,
            'loginPassword'=>$password
        ];

        $arr = UserInfoApi::create()->registerUser($data, 'userName', $userName);

        return response()->json($arr, 200);
    }

    /**
     * 功能：修改密码
     * @return \Illuminate\Http\JsonResponse
     * http://localhost:8888/ajaxPost
     * 响应请求 方法 POST
     * http://localhost:8888/api/admin/update/password
     */
    public function updateUserPassword()
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $arr = UserInfoApi::create()->updateUserPassword(['loginPassword'=>$password], 'userName', $username);

        return response()->json($arr, 200);
    }

}