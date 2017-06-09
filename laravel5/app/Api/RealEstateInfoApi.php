<?php

namespace App\Api;
use App\Events\RealEstateInfoChanged;
use App\Events\RealEstateRegistered;
use App\Repositories\RealEstateInfoRepository as RealEstateMgr;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Event;

/** !!!!没有使用CREATE_FUNC的例子 */
class RealEstateInfoApi
{

    /**
     * 仓库管理员
     *
     * @var RealEstateMgr
     */
    private $realEstateMgr;

    /**
     * RealEstateInfoApi constructor.
     *
     * 传入具体的仓库管理类
     * @param RealEstateMgr $realEstateMgr
     */
    private function __construct(RealEstateMgr $realEstateMgr)
    {
        $this->realEstateMgr = $realEstateMgr;
    }

    /**
     * 创建实例
     *
     * @return RealEstateInfoApi|null
     */
    public static function create()
    {
        // 实例化管理员
        /** 传入App的实例 */
        $realEstateMgr = new RealEstateMgr(App::getInstance());

        $instance = new RealEstateInfoApi($realEstateMgr);
        if($instance != null){
            return $instance;
        }
        return null;
    }

    /**
     * 功能：验证物业否已存在
     * @param $dbName
     * @return array
     */
    public function isRealEstateExist($dbName)
    {
        $isExist = $this->realEstateMgr->isFieldExist('dbName', $dbName);

        if($isExist){
            return ['isExist'=>'true'];
        }

        return ['isExist'=>'false'];
    }

    /**
     * 功能：获取$dbName对应的物业信息
     * @param $dbName
     * @return array
     */
    public function getRealEstateInfo($dbName)
    {
        $realEstateMap = $this->realEstateMgr->findBy('dbName', $dbName);

        $resultArray = null;
        if(count($realEstateMap) > 0){
            $resultArray = [
                'dbName'=>$realEstateMap['dbName'],
                'realEstateName'=>$realEstateMap['realEstateName'],
                'address'=>$realEstateMap['address'],
                'description'=>$realEstateMap['description'],
                'manageCompany'=>$realEstateMap['manageCompany'],
                'serviceEndDateTime'=>$realEstateMap['serviceEndDateTime'],
                'contactPersonName'=>$realEstateMap['contactPersonName'],
                'contactTel'=>$realEstateMap['contactTel'],
                'longitude'=>$realEstateMap['longitude'],
                'latitude'=>$realEstateMap['latitude'],
                'isDiscarded'=>(string)$realEstateMap['isDiscarded'],
                'nodeInfo_nodeName'=>(string)$realEstateMap['nodeInfo_nodeName'],
//                'dbIp'=>$realEstateMap['dbIp'],
//                'dbPort'=>$realEstateMap['dbPort'],
//                'dbUserName'=>$realEstateMap['dbUserName'],
//                'dbPassword'=>$realEstateMap['dbPassword']
            ];
        }

        return ['data'=>$resultArray];
    }

    /**
     * 功能：获取所有的物业信息
     * @return array
     */
    public function getRealEstateInfoList()
    {
        $realEstateModelArray= $this->realEstateMgr->all();

        $resultArray = array();
        if(count($realEstateModelArray) > 0){
            foreach ($realEstateModelArray as $item) {
                $tmpArray = [
                    'dbName'=>$item->dbName,
                    'realEstateName'=>$item->realEstateName,
                    'address'=>$item->address,
                    'description'=>$item->description,
                    'manageCompany'=>$item->manageCompany,
                    'serviceEndDateTime'=>$item->serviceEndDateTime,
                    'contactPersonName'=>$item->contactPersonName,
                    'contactTel'=>$item->contactTel,
                    'longitude'=>(string)$item->longitude,
                    'latitude'=>(string)$item->latitude,
                    'isDiscarded'=>(string)$item->isDiscarded,
                    'nodeInfo_nodeName'=>(string)$item->nodeInfo_nodeName,
//                'dbIp'=>$realEstateMap['dbIp'],
//                'dbPort'=>$realEstateMap['dbPort'],
//                'dbUserName'=>$realEstateMap['dbUserName'],
//                'dbPassword'=>$realEstateMap['dbPassword']
                ];
                $resultArray[] = $tmpArray;
            }
        }

        return ['data'=>$resultArray];
    }

    /**
     * 功能：插入一条新的信息
     *
     * @param array $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function registerRealEstateInfo(array $data, $primaryKey, $value)
    {
        $map =  $this->realEstateMgr->create_Ex($data, $primaryKey, $value);

        if($map['status'] == 'success' && $map['isExist'] == 'false')
        {
//            // TODO... 1.create realEstateInfo database.
//            $input = [
//                'database'=>$primaryKey_dbName,
//                'ip'=>$dbIp,
//                'port'=>$dbPort,
//                'user'=>$dbUserName,
//                'password'=>$dbPassword
//            ];
//            $this->__registerDatabase($input);
//
//            // TODO... 2.同步nodeinfo表，其中realestate_info表中的外键nodeinfo_nodeName对应nodeinfo表中主键nodeName
            $input_data = [
                'dbName'=>$data['dbName'],
                'realEstateName'=>$data['realEstateName'],
                'address'=>$data['address'],
                'description'=>$data['description']
            ];
            Event::fire(new RealEstateInfoChanged($input_data, 0));
        }

        // 回滚失败操作 TODO

        return $map;
    }

    /**
     * 功能：更新物业信息
     *
     * @param array $data
     * @param $primaryKey
     * @param $value
     * @return array
     */
    public function updateRealEstateInfo(array $data, $primaryKey, $value)
    {
        $map = $this->realEstateMgr->update_Ex($data, $primaryKey, $value);

        if($map['status'] == 'success' && $map['isExist'] == 'true')
        {
            $input_data = [
                'dbName'=>$data['dbName'],
                'realEstateName'=>$data['realEstateName'],
                'address'=>$data['address'],
                'description'=>$data['description']
            ];
            Event::fire(new RealEstateInfoChanged($input_data, 1));
        }

        // 回滚失败操作 TODO

        return $map;
    }


    /**
     * 功能：获取数据库所在服务器的Mysql的连接信息
     *
     * @param $dbName
     * @return array
     */
    public function getRealEstateDBInfo($dbName)
    {
        $realEstateMap = $this->realEstateMgr->findBy('dbName', $dbName);

        $resultArray = null;
        if(count($realEstateMap) > 0){
            $resultArray = [
                'dbName'=>$realEstateMap['dbName'],
                'dbIp'=>$realEstateMap['dbIp'],
                'dbPort'=>$realEstateMap['dbPort'],
                'dbUserName'=>$realEstateMap['dbUserName'],
                'dbPassword'=>$realEstateMap['dbPassword']
            ];
        }

        return ['data'=>$resultArray];
    }


    /**
     * 功能: 获得数据库$dbName对应的服务器节点的连接信息
     *
     * @param $dbName
     * @return mixed
     */
    public function getNodeServerInfo($dbName)
    {
        // 获得节点的名称
        $map = $this->realEstateMgr->findBy('dbName', $dbName, ['nodeInfo_nodeName']);
        $nodeName = $map['nodeInfo_nodeName'];

        // 获得对应节点名称的该服务器节点的连接信息
        $data = NodeInfoApi::create()->getNodeServerInfo($nodeName);

        return $data;
    }


    /**
     * 功能：获得节点（名字为$nodeName）下的物业列表(数据库版)
     * @param $nodeName
     * @return array
     */
    public function getRealEstateWithDBInfoList($nodeName)
    {
        $collection =  $this->realEstateMgr->find2NBy('nodeInfo_nodeName', $nodeName, [
            'dbName',
            'realEstateName',
            'dbIp',
            'dbPort',
            'dbUserName',
            'dbPassword'
        ]);
        $data = array();
        if(count($collection) > 0){
            foreach ($collection as $item) {
                $tmp = [
                    'dbName'=>$item->dbName,
                    'realEstateName'=>$item->realEstateName,
                    'dbIp'=>$item->dbIp,
                    'dbPort'=>$item->dbPort,
                    'dbUserName'=>$item->dbUserName,
                    'dbPassword'=>$item->dbPassword,
                ];
                $data[] = $tmp;
            }
        }
        return ['data'=>$data];
    }


    /**
     * 功能：获得节点（名字为$nodeName）下的物业列表
     * @param $nodeName
     * @return array
     */
    public function getRealEstateListOfNode($nodeName)
    {
        $collection =  $this->realEstateMgr->find2NBy('nodeInfo_nodeName', $nodeName, [
            'dbName',
            'realEstateName',
            'address',
            'description',
            'manageCompany',
            'serviceEndDateTime',
            'contactPersonName',
            'contactTel',
            'longitude',
            'latitude',
            'isDiscarded',
            'nodeInfo_nodeName'

        ]);
        $data = array();
        if(count($collection) > 0){
            foreach ($collection as $item) {
                $tmp = [
                    'dbName'=>$item->dbName,
                    'realEstateName'=>$item->realEstateName,
                    'address'=>$item->address,
                    'description'=>$item->description,
                    'manageCompany'=>$item->manageCompany,
                    'serviceEndDateTime'=>$item->serviceEndDateTime,
                    'contactPersonName'=>$item->contactPersonName,
                    'contactTel'=>$item->contactTel,
                    'longitude'=>(string)$item->longitude,
                    'latitude'=>(string)$item->latitude,
                    'isDiscarded'=>(string)$item->isDiscarded,
                    'nodeInfo_nodeName'=>(string)$item->nodeInfo_nodeName,
                ];
                $data[] = $tmp;
            }
        }
        return ['data'=>$data];
    }
}