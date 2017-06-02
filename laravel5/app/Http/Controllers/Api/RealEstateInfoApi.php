<?php

namespace App\Http\Controllers\Api;
use App\Events\RealEstateRegistered;
use App\Repositories\RealEstateInfoRepository as RealEstateMgr;
use Illuminate\Container\Container as App;
use Illuminate\Support\Facades\Event;

class RealEstateInfoApi
{
    private $realEstateMgr;

    private function __construct(RealEstateMgr $realEstateMgr)
    {
        $this->realEstateMgr = $realEstateMgr;
    }

    public static function create()
    {
        // 实例化管理员
        $realEstateMgr = new RealEstateMgr(App::getInstance());

        $instance = new RealEstateInfoApi($realEstateMgr);
        if($instance != null){
            return $instance;
        }
        return null;
    }

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
            //Event::fire(new RealEstateRegistered());

            return ['status'=>'success', 'isExist'=>'false'];
        }elseif ($map['status'] == 'fail' && $map['isExist'] == 'true'){//插入失败， 因为主键已经存在
            return ['status'=>'fail', 'isExist'=>'true'];
        }elseif ($map['status'] == 'fail' && $map['isExist'] == 'false'){
            return ['status'=>'fail', 'isExist'=>'false'];
        }
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
        return $this->realEstateMgr->update_Ex($data, $primaryKey, $value);
    }

}