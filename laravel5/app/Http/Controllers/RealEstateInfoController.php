<?php

namespace App\Http\Controllers;

use App\Api\RealEstateInfoApi;
use App\Http\Controllers\Handlers\NodeInfoHandler;
use App\Repositories\RealEstateInfoRepository as RealEstateInfoMgr;
use Illuminate\Support\Facades\Input;

/**
 * Class RealEstateInfoController
 * @package App\Http\Controllers
 */
class RealEstateInfoController extends Controller
{
    /**
     * 物业信息表的仓库管理员
     *
     * @var realEstateInfoMgr
     */
    private $realEstateInfoMgr;

    /**
     * assign value to $user by DI(依赖注入)
     *
     * UserInfoController constructor.
     * @param RealEstateInfoMgr $realEstateInfoMgr
     */
    public function __construct(RealEstateInfoMgr $realEstateInfoMgr)
    {
        $this->realEstateInfoMgr = $realEstateInfoMgr;
    }

    /**
     * 功能：验证物业是否已存在
     * @param $dbName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/realEstate/jinyehotel
     */
    public function isRealEstateExist($dbName)
    {
        $arr = RealEstateInfoApi::create()->isRealEstateExist($dbName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取特定物业信息
     * @param $dbName 物业(一般是小区)名字
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/realEstateInfo/jinyehotel
     */
    public function getRealEstateInfo($dbName)
    {
        $arr = RealEstateInfoApi::create()->getRealEstateInfo($dbName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获取所有的物业信息
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/realEstateInfoList
     */
    public function getRealEstateInfoList()
    {
        $arr = RealEstateInfoApi::create()->getRealEstateInfoList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：插入一条新的信息
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/ajaxPost
     * http://localhost:8888/api/admin/register/realEstate
     */
    public function registerRealEstateInfo()
    {
        $primaryKey_dbName = Input::get('dbName');
        $dbIp = Input::get('dbIp');
        $dbPort = Input::get('dbPort');
        $dbUserName = Input::get('dbUserName');
        $dbPassword = Input::get('dbPassword');
        $nodeName = Input::get('nodeInfo_nodeName');
        $data = [
            'dbName'=>$primaryKey_dbName,
            'realEstateName'=>Input::get('realEstateName'),
            'address'=>Input::get('address'),
            'description'=>Input::get('description'),
            'manageCompany'=>Input::get('manageCompany'),
            'serviceEndDateTime'=>Input::get('serviceEndDateTime'),
            'contactPersonName'=>Input::get('contactPersonName'),
            'contactTel'=>Input::get('contactTel'),
            'longitude'=>Input::get('longitude'),
            'latitude'=>Input::get('latitude'),
            'nodeInfo_nodeName'=>$nodeName,
            'dbIp'=>$dbIp,
            'dbPort'=>$dbPort,
            'dbUserName'=>$dbUserName,
            'dbPassword'=>$dbPassword,
            'isDiscarded'=>Input::get('isDiscarded')
        ];

        $arr = RealEstateInfoApi::create()->registerRealEstateInfo($data, 'dbName', $primaryKey_dbName);

        return response()->json($arr, 200);
    }

    /**
     * 功能：更新物业信息
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/admin/update/realEstate
     */
    public function updateRealEstateInfo()
    {
        $primaryKey_dbName = Input::get('dbName');
        $data = [
            'dbName'=>$primaryKey_dbName,
            'realEstateName'=>Input::get('realEstateName'),
            'address'=>Input::get('address'),
            'description'=>Input::get('description'),
            'manageCompany'=>Input::get('manageCompany'),
            'serviceEndDateTime'=>Input::get('serviceEndDateTime'),
            'contactPersonName'=>Input::get('contactPersonName'),
            'contactTel'=>Input::get('contactTel'),
            'longitude'=>Input::get('longitude'),
            'latitude'=>Input::get('latitude'),
            'nodeInfo_nodeName'=>Input::get('nodeInfo_nodeName'),
            'dbIp'=>Input::get('dbIp'),
            'dbPort'=>Input::get('dbPort'),
            'dbUserName'=>Input::get('dbUserName'),
            'dbPassword'=>Input::get('dbPassword'),
            'isDiscarded'=>Input::get('isDiscarded')
        ];

        $arr = RealEstateInfoApi::create()->updateRealEstateInfo($data, 'dbName', $primaryKey_dbName);

        return response()->json($arr,200);
    }


//// http://localhost:8888/test/西北节点
//    public function getRealEstateWithDBInfoList($nodeName)
//    {
//        $arr = RealEstateInfoApi::create()->getRealEstateWithDBInfoList($nodeName);
//        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
//    }


    // TODO... create realEstateInfo database.
    //$data = [
    //'database'=>$primaryKey_dbName,
    //'ip'=>$dbIp,
    //'port'=>$dbPort,
    //'user'=>$dbUserName,
    //'password'=>$dbPassword
    //];
    private function __registerDatabase(array $data)
    {
    }

    private function __syncNodeInfoTable($nodeName)
    {
        $nodeInfoObj = NodeInfoHandler::create();
        if(!$nodeInfoObj->isNodeExist($nodeName))
        {
            $data = [
                'nodeName'=>$nodeName,
                'nodeIp'=>'',
                'nodePort'=>'',
                'nodeUserName'=>'',
                'nodePassword'=>'',
                'address'=>'',
                'remark'=>'',
            ];
            return $nodeInfoObj->registerNodeInfo($data);
        }
    }

}
