<?php

namespace App\Http\Controllers\Handlers;

use App\Models\NodeInfoModel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class NodeInfoHandler extends Controller
{
    public static function create()
    {
        $instance = new NodeInfoHandler();
        if($instance != null){
            return $instance;
        }
        return null;
    }


    /**
     * @param $nodeName
     * @return bool
     */
    public function isNodeExist($nodeName)
    {
        $isExist = false;

        $model = NodeInfoModel::where('nodeName', $nodeName)->first(['nodeName']);
        if($model != null){
            $isExist = true;
        }

        return $isExist;
    }

    public function registerNodeInfo(array $data /*, $nodeName*/)
    {

//        $isExist = $this->isNodeExist($nodeName);
//        if($isExist){
//            return ['status'=>'fail', 'isExist'=>'true'];
//        }

        // data doesn't exist; insert it right now.
        $m = NodeInfoModel::create($data);
        if($m != null){
            return ['status'=>'success', 'isExist'=>'false'];
        }else{
            return ['status'=>'fail', 'isExist'=>'false'];
        }
    }

    public function updateNodeInfo(array $data /*, $nodeName*/)
    {

//        $isExist = $this->isNodeExist($nodeName);
//        if($isExist){
//            return ['status'=>'fail', 'isExist'=>'true'];
//        }

        // data doesn't exist; insert it right now.
        $m = (new NodeInfoModel())->update($data);
        if($m != null){
            return ['status'=>'success', 'isExist'=>'false'];
        }else{
            return ['status'=>'fail', 'isExist'=>'false'];
        }
    }
}
