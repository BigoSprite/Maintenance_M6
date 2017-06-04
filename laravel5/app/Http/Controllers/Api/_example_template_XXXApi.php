<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Http\Controllers\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the $repositoryMgr(REPOSITORY MANAGER) */
class _example_template_XXXApi extends Api
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
        /** @NOTE 魔术常量__NAMESPACE__表示$__CLASS_NAME__的当前命名空间 */
        return ApiInstanceFactory::CREATE_FUNC(
            '_example_template_XXXApi',
            __NAMESPACE__,
            '_example_template_XXXRepository',
            'App\Repositories'
        );
    }

    /**
     * 功能：判断XXX对应的数据对象是否存在
     * @param $XXX
     * @return array
     *
     * @NOTE Don't forget to CHANGE XXX to the right attribute!
     */
    public function isXXXExist/** 1*/($XXX/** 2*/)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('_example_primaryKey_name_'/** 3*/, $XXX/** 4*/);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }

    /**
     * 功能：注册
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function register($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->create_Ex($data, $primaryKey, $value);
    }

    /**
     * 功能：更新
     * @param $data
     * @param $primaryKey
     * @param $value
     * @return mixed
     */
    public function update($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }

    /**
     * Other Method
     *
     * @NOTE you can add you own method like this.
     *
     */
    public function otherMethod()
    {
        //
    }
}