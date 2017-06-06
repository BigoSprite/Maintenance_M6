<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Api;
use App\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class UserInfoApi extends Api
{
    /**
     * Constructor.
     *
     * @param AbstractRepository $repository
     * @NOTE you HAVE TO implement constructor and call parent constructor like follow.
     */
    public function __construct(AbstractRepository $repository)
    {
        /** Don't forget to call parent constructor. */
        parent::__construct($repository);
    }

    /**
     * Create Function
     *
     * @return object
     */
    public static function create()
    {
        /** CREATE_FUNC like Cocos2d-x's CREATE_FUNC */
        /** Don't forget to CHANGE the parameters of CREATE_FUNC! */
        /** @NOTE 魔术常量__NAMESPACE__表示的当前命名空间 */
        return ApiInstanceFactory::CREATE_FUNC(
            'UserInfoApi',
            __NAMESPACE__,
            'UserInfoRepository',
            'App\Repositories'
        );
    }

    /**
     * 功能：获取所有信息
     * 响应请求 方法 GET
     *
     * @return array
     */
    public function all()
    {
        $modelArray = $this->repositoryMgr->all();

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

        $userInfoMap =  $this->repositoryMgr->findBy('userName', $username);

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
        $isExist = $this->repositoryMgr->isFieldExist('userName', $userName);

        if($isExist){
            return ['isExist'=>'true'];
        }

        return ['isExist'=>'false'];
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
        return $this->repositoryMgr->create_Ex($data, $primaryKey, $value);
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
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }

}