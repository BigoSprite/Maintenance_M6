<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Http\Controllers\Api\Node;
use App\Http\Controllers\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Http\Controllers\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class Real_Estate_Info_Api extends Api
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
        return ApiInstanceFactory::CREATE_FUNC(
            'Real_Estate_Info_Api',
            __NAMESPACE__,
            'Real_Estate_Info_Repository',
            'App\Repositories\NodeRepository'
        );
    }

    /**
     * 功能：判断$dbName对应的物业信息是否存在
     * @param $dbName
     * @return array
     */
    public function isDBNameExist($dbName)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('dbName', $dbName);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }

    /**
     * 功能：获取$dbName对应的物业信息
     * @param $dbName
     * @return array
     */
    public function get_Real_Estate_Info($dbName)
    {
        $arrMap = $this->repositoryMgr->findBy('dbName', $dbName);
        $retArray = array();
        if(count($arrMap) > 0){
            $retArray = [
                "dbName"=> $arrMap['dbName'],
                "realEstateName"=>$arrMap['realEstateName'],
                "address"=>$arrMap['address'],
                "description"=>$arrMap['description'],
            ];
        }

        return ["data"=>$retArray];
    }

    /**
     * 功能：获取全部物业信息
     * @return array
     */
    public function get_Real_Estate_Info_List()
    {
        $modelList = $this->repositoryMgr->all();

        $retArray = array();
        if(count($modelList) > 0){
            foreach ($modelList as $model) {
                // 构造临时数组
                $tmp_array = [
                    "dbName"=> $model->dbName,
                    "realEstateName"=>$model->realEstateName,
                    "address"=>$model->address,
                    "description"=>$model->description,
                ];

                // 加入最终的数组中
                $retArray[] = $tmp_array;
            }
        }

        return ["data"=>$retArray];
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
     * @return array
     */
    public function update($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }

}