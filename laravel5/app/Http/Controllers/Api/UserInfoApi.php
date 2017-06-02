<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/6/1
 * Time: 9:43
 */

namespace App\Http\Controllers\Api;
use App\Repositories\UserInfoRepository as UserMgr;
use Illuminate\Container\Container as App;

class UserInfoApi
{
    /**
     * 用户信息表仓库管理员
     *
     * the model table userinfo
     * @var
     */
    private $userMgr;

    /**
     * assign value to $userMgr by DI(依赖注入)
     *
     * UserInfoApi constructor.
     * @param UserMgr $userMgr
     */
    private function __construct(UserMgr $userMgr)
    {
        $this->userMgr = $userMgr;
    }

    /**
     * 创建型方法
     *
     * @return UserInfoApi|null
     */
    public static function create()
    {
        // 实例化管理员
        $userMgr = new UserMgr(App::getInstance());

        $instance = new UserInfoApi($userMgr);
        if($instance != null){
            return $instance;
        }
        return null;
    }


    /**
     * 功能：获取所有信息
     * 响应请求 方法 GET
     *
     * @return array
     */
    public function all()
    {
        $modelArray = $this->userMgr->all();

        $data = array();

        foreach ($modelArray as $item) {
            $tmp = [
                'username' => $item->userName,
                'loginPassword' => $item->loginPassword
            ];

            $data[] = $tmp;
        }
        return ['data'=>$data];
    }

    /**
     * 功能：验证用户名和密码是否正确
     * @param $data
     * @return array
     */
    public function verifyLogin($data)
    {
        $username = $data['userName'];
        $password = $data['loginPassword'];

        $userInfoMap =  $this->userMgr->findBy('userName', $username);

        if(count($userInfoMap) > 0){
            if( $userInfoMap['userName'] == $username && $userInfoMap['loginPassword'] == $password){
                return ['status'=>'success'];
            }
        }
        return ['status'=>'fail'];
    }

    /**
     * 功能：验证用户名是否已存在
     * @param $userName
     * @return array
     */
    public function isUserNameExist($userName)
    {
        $isExist = $this->userMgr->isFieldExist('userName', $userName);

        if($isExist){
            return ['isExist'=>'true'];
        }else{
            return ['isExist'=>'false'];
        }
    }

    /**
     * 功能：注册用户
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function registerUser($data, $primaryKey, $value)
    {
        return $this->userMgr->create_Ex($data, $primaryKey, $value);
    }

    /**
     * 功能：修改密码
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function updateUserPassword($data, $primaryKey, $value)
    {
        return $this->userMgr->update_Ex($data, $primaryKey, $value);
    }

}