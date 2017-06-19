<?php

namespace App\Api;
use App\Api\Contracts\Api;
use App\Api\Utils\ApiInstanceFactory;
use App\Api\Utils\DBDirector;
use App\Repositories\Eloquent\AbstractRepository;

class NodeInfoApi extends Api
{
    public function __construct(AbstractRepository $repository)
    {
        parent::__construct($repository);
    }

    public static function create()
    {
        return ApiInstanceFactory::CREATE_FUNC(
            'NodeInfoApi',
            __NAMESPACE__,
            'NodeInfoRepository',
            'App\Repositories'

            );
    }

    public function isNodeExist($nodeName)
    {
        $isExist = $this->repositoryMgr->isFieldExist('nodeName', $nodeName);

        if($isExist){
            return ['isExist'=>'true'];
        }

        return ['isExist'=>'false'];
    }

    public function all()
    {
        $modelArray = $this->repositoryMgr->all();

        $data = array();

        foreach ($modelArray as $item) {
            $tmp = [
                'nodeName' => $item->nodeName,
                'nodeIp' => $item->nodeIp,
                'nodePort'=>(string)$item->nodePort,
                'nodeUserName'=>$item->nodeUserName,
                'nodePassword'=>$item->nodePassword,
                'address'=>$item->address,
                'remark'=>$item->remark,
            ];

            $data[] = $tmp;
        }
        return ['data'=>$data];
    }

    public function getNodeNameList()
    {
        $nameArr = $this->repositoryMgr->all(['nodeName']);
        $data = array();

        foreach ($nameArr as $item) {
            $tmp = [
                'nodeName'=>$item->nodeName
            ];
            $data[] = $tmp;
        }

        return ['data'=>$data];
    }

    public function getNodeServerInfo($nodeName)
    {
        $arrMap = $this->repositoryMgr->findBy('nodeName', $nodeName, ['nodeIp', 'nodePort', 'nodeUserName', 'nodePassword']);

        $data = array();

        if(count($arrMap) > 0){
            $data = [
                'nodeIp'=>$arrMap['nodeIp'],
                'nodePort'=>(string)$arrMap['nodePort'],
                'nodeUserName'=>$arrMap['nodeUserName'],
                'nodePassword'=>$arrMap['nodePassword'],
            ];
        }

        return ['data'=>$data];
    }

    public function getNodeInfo($nodeName)
    {
        $arrMap = $this->repositoryMgr->findBy('nodeName', $nodeName);

        $data = array();

        if(count($arrMap) > 0){
            $data = [
                'nodeName'=>$nodeName,
                'nodeIp'=>$arrMap['nodeIp'],
                'nodePort'=>(string)$arrMap['nodePort'],
                'nodeUserName'=>$arrMap['nodeUserName'],
                'nodePassword'=>$arrMap['nodePassword'],
                'address'=>$arrMap['address'],
                'remark'=>$arrMap['remark']
            ];
        }

        return ['data'=>$data];
    }

    public function registerNodeInfo($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->create_Ex($data, $primaryKey, $value);
    }

    public function updateNodeInfo($data, $primaryKey, $value)
    {
        return $this->repositoryMgr->update_Ex($data, $primaryKey, $value);
    }


    /**
     * 功能：获取节点树上的数据
     *
     * @return array
     */
    public function getNodeTree()
    {
        // 1. 得节点的名字数组
        $objNameArr = $this->repositoryMgr->all(['nodeName']);
        $nodeNameList = array();
        foreach ($objNameArr as $obj) {
            $nodeNameList[] = $obj->nodeName;
        }

        $retData = array();

        // 2. 遍历节点名字数组并增加物业名字和配电室列表
        foreach ($nodeNameList as $nodeName) {

            $elemNode = [
                'label'=>$nodeName,
                'children'=>[]
            ];

            // 获得物业名字数组
            $data = RealEstateInfoApi::create()->getRealEstateWithDBInfoList($nodeName);
            $realEstateNameList = $data['data'];
            // 遍历物业名字数组，获得物业label及该物业下的所有配电室
            foreach ($realEstateNameList as $item) {
                $dbName = $item['dbName'];
                $tmp = [
                    'label'=> $item['realEstateName'],
                    'children'=>[],
                    'database'=>$dbName
                ];

                // ---------连接远程数据库----------------
                $dbIp = $item['dbIp'];
                $dbPort = $item['dbPort'];
                $dbUserName= $item['dbUserName'];
                $dbPassword = $item['dbPassword'];
                $conn = DBDirector::getInstance()->connection($dbIp, $dbName, $dbUserName, $dbPassword);
                if($conn != null){// 连接成功
                    $modelArr = $conn->select("SELECT * FROM distribution_room_info");
                    foreach ($modelArr as $e) {
                        $tmp['children'][] = [
                            'database'=>$dbName,
                            'label'=>$e->roomName,
                            'serialId'=>$e->serialId
                        ];
                    }
                }else{// ！！！连接失败---数据库不存在，应该先配置具体物业的数据库
                    continue;
                }

                $elemNode['children'][] = $tmp;
            }
            $retData[] = $elemNode;
        }

        return ['data'=>$retData];
    }

}