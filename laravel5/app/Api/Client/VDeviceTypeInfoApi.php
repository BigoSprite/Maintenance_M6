<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Api\Client;
use App\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class VDeviceTypeInfoApi extends Api
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
     * @param string $runtimeDatabaseName
     * @return object
     */
    public static function create(string $runtimeDatabaseName = "")
    {
        /** Don't forget to configure model's connection, if you wanna change database at runtime! */
        parent::configureConnection($runtimeDatabaseName);

        /** CREATE_FUNC like Cocos2d-x's CREATE_FUNC */
        /** Don't forget to CHANGE the parameters of CREATE_FUNC! */
        /** @NOTE 魔术常量__NAMESPACE__表示的当前命名空间 */
        return ApiInstanceFactory::CREATE_FUNC(
            'VDeviceTypeInfoApi',
            __NAMESPACE__,
            'VDeviceTypeInfoRepository',
            'App\Repositories\ClientRepository'
        );
    }

    /**
     * 功能：判断XXX对应的数据对象是否存在
     * @param $name
     * @return array
     *
     * @NOTE Don't forget to CHANGE XXX to the right attribute!
     */
    public function isDeviceTypeExist($name)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('name', $name);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }

    /**
     * 功能：获得特定设备类型名称（name）的设备信息
     *
     * @param $name
     * @return array
     */
    public function getDeviceTypeInfo($name)
    {
        $modelArr = $this->repositoryMgr->findBy('name', $name);
        $data = null;
        if($modelArr != null){
            $data = [
                'name'=>$modelArr['name'],
                'typeDesc'=>$modelArr['typeDesc']
            ];
        }

        return ['data'=>$data];
    }

    /**
     * 功能：获取所有设备类型的信息
     *
     * @return array
     */
    public function getDeviceTypeInfoList()
    {
        $objArr = $this->repositoryMgr->all();
        $data = array();
        if(count($objArr) > 0){
            foreach ($objArr as $obj) {
                $tmp = [
                    'name'=>$obj->name,
                    'typeDesc'=>$obj->typeDesc
                ];
                $data[] = $tmp;
            }

        }
        return ['data'=>$data];
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