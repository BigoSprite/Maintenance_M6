<?php
/**
 * Created by PhpStorm.
 * User: hzw
 * Date: 2017/5/05
 * Time: 10:26
 */
namespace App\Http\Controllers\ComponentCommon;

use App\Http\Controllers\Utility\DBConnectinHandler;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\ModelCenter\User_Information_Model;

class UserInfoController extends Controller
{
    public function __construct()
    {
    }

    // 判断输入的用户是否存在
    public function  isUserExist(Request $request)
    {
        $username = Input::get('username');
        $password = Input::get('password');

        $dbInfo = [
            'dbIp'=>'127.0.0.1',
            'dbName'=>'hwdevicecloud',
            'dbUser'=>'root',
            'dbPassword'=>'root'
        ];
        $con = DBConnectinHandler::getInstance()->connection($dbInfo['dbIp'], $dbInfo['dbName'], $dbInfo['dbUser'], $dbInfo['dbPassword']);
        $user =$con->select('SELECT * FROM userinfo WHERE userName = :userName AND loginPassword = :password',
            [':userName'=>$username, ':password'=>$password]);

        if(count($user) > 0){
            $result = [
                'status'=>'success'
            ];
        }else{
            $result = [
                'status'=>'fail'
            ];
        }

        return response()->json($result, 200);
    }
}