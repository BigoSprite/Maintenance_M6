<?php

namespace App\Http\Controllers\Client;

use App\Api\Client\DistributionRoomInfoApi;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DistributionRoomInfoController extends Controller
{
    /**
     * 功能：判断$serialId对应的数据对象是否存在
     * @param $dbName
     * @param $serialId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/distributionRoom/jinyehotel/1
     */
    public function isRoomExist($dbName, $serialId)
    {
        $arr = DistributionRoomInfoApi::create($dbName)->isRoomExist($serialId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：判断$roomName对应的数据对象是否存在
     * @param $dbName
     * @param $roomName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/verify/distributionRoomEx/jinyehotel/配电室1
     */
    public function isRoomExist_Ex($dbName, $roomName)
    {
        $arr = DistributionRoomInfoApi::create($dbName)->isRoomExist_Ex($roomName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
 * 功能：从distribution_Room_info表中获得“某序列号”对应的一行（配电室的所有属性）
 * @param $dbName
 * @param $serialId
 * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
 *
 * 响应请求 方法 GET
 * http://localhost:8888/api/content/distributionRoomInfo/jinyehotel/0
 */
    public function getRoomInfo($dbName, $serialId)
    {
        $arr = DistributionRoomInfoApi::create($dbName)->getRoomInfo($serialId);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：从distribution_Room_info表中获得$roomName对应的一行（配电室的所有属性）
     * @param $dbName
     * @param $roomName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/distributionRoomInfoEx/jinyehotel/配电室1
     */
    public function getRoomInfo_Ex($dbName, $roomName)
    {
        $arr = DistributionRoomInfoApi::create($dbName)->getRoomInfo_Ex($roomName);

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：从从distribution_Room_info表中获得所有配电室信息
     * @param $dbName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/distributionRoomInfoList/jinyehotel
     */
    public function getRoomInfoList($dbName)
    {
        $arr = DistributionRoomInfoApi::create($dbName)->getRoomInfoList();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：获得所有配电室名字及其序列号
     * @param $dbName
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * 响应请求 方法 GET
     * http://localhost:8888/api/content/distributionRoomNameList/serialId/jinyehotel
     */
    public function getRoomNameListWithSerialId($dbName)
    {
        $arr = DistributionRoomInfoApi::create($dbName)->getRoomNameListWithSerialId();

        return response(json_encode($arr, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 功能：注册配电室
     * @param $dbName
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/register/distributionRoom/jinyehotel
     * http://localhost:8888/ajaxPost
     */
    public function registerRoom($dbName)
    {
        $roomName = Input::get('roomName');
        $data = [
            'roomName'=>$roomName,
            'description'=>Input::get('description'),
            'address'=>Input::get('address'),
            'contactPerson'=>Input::get('contactPerson'),
            'contactTel'=>Input::get('contactTel')
        ];

        $arr = DistributionRoomInfoApi::create($dbName)->register($data, 'roomName', $roomName);

        return response()->json($arr, 200);
    }

    /**
     * 功能：更新电室
     * @param $dbName
     * @return \Illuminate\Http\JsonResponse
     *
     * 响应请求 方法 POST
     * http://localhost:8888/api/content/update/distributionRoom/jinyehotel
     * http://localhost:8888/ajaxPost
     */
    public function updateRoom($dbName)
    {
        $serialId = Input::get('serialId');
        $data = [
            'roomName'=>Input::get('roomName'),
            'description'=>Input::get('description'),
            'address'=>Input::get('address'),
            'contactPerson'=>Input::get('contactPerson'),
            'contactTel'=>Input::get('contactTel')
        ];

        $arr = DistributionRoomInfoApi::create($dbName)->update($data, 'serialId', $serialId);

        return response()->json($arr, 200);
    }

}
