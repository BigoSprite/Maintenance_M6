<?php

/**
 * This file is created by hanzhiwei using _example_template_XXXApi.php
 *
 * @Copyright
 *      @user: hanzhiwei
 *      @Email: bigosprite@163.com
 *      @GitHub: https://github.com/BigoSprite
 */

namespace App\Api\Node;
use App\Api\Contracts\Api;
use App\Repositories\Eloquent\AbstractRepository;
use App\Api\Utils\ApiInstanceFactory;

/** MAKE SURE that yourApi class extents Api in order to use the (REPOSITORY MANAGER) */
class VDeviceNodeInfoApi extends Api
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
            'VDeviceNodeInfoApi',
            __NAMESPACE__,
            'VDeviceNodeInfoRepository',
            'App\Repositories\NodeRepository'
        );
    }


    /**
     * 功能：判断$nodeName对应的节点是否存在
     * @param $nodeName
     * @return array
     */
    public function isNodeExist($nodeName)
    {
        $ret = [
            'isExist'=>'false'
        ];

        $isExist = $this->repositoryMgr->isFieldExist('nodeName', $nodeName);

        if($isExist){
            $ret['isExist'] = 'true';
        }

        return $ret;
    }

    /**
     * 功能：获取$nodeName对应的节点信息
     * @param $nodeName
     * @return array
     */
    public function getNodeInfo($nodeName)
    {
        $arrMap = $this->repositoryMgr->findBy('nodeName', $nodeName);

        $retArray = array();
        if(count($arrMap) > 0){
            $retArray = [
                "nodeName"=> $arrMap['nodeName'],
                "nodeRemark"=>$arrMap['nodeRemark'],
            ];
        }

        return ["data"=>$retArray];
    }

    /**
     * 功能：获取全部节点信息
     * @return array
     */
    public function getNodeList()
    {
        $nodeList = $this->repositoryMgr->all();

        $retArray = array();
        if(count($nodeList) > 0){
            foreach ($nodeList as $obj) {
                // 构造临时数组
                $tmp_array = [
                    "nodeName"=> $obj->nodeName,
                    "nodeRemark"=> $obj->nodeRemark,
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