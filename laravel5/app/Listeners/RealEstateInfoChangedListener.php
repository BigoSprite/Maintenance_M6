<?php

namespace App\Listeners;

use App\Events\RealEstateInfoChanged;
use App\Models\Node\Real_Estate_Info_Model;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RealEstateInfoChangedListener
{

    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RealEstateInfoChanged  $event
     * @return void
     */
    public function handle(RealEstateInfoChanged $event)
    {
        $data = $event->realEstateData;
        $type = $event->type;
        $dbName = $data['dbName'];

        $realEstateModel = new Real_Estate_Info_Model();
        $realEstateModel->dbName = $dbName;
        $realEstateModel->realEstateName = $data['realEstateName'];
        $realEstateModel->address = $data['address'];
        $realEstateModel->description = $data['description'];

        switch ($type){// 事件的类型
            case 0:// 注册
            {
                if(!$realEstateModel->save()){
                    echo "Error: register failed! at RealEstateInfoChangedListener's function handle.";
                }

                break;
            }
            case 1:// 更新
            {
                $realEstateModel->where('dbName', '=', $dbName)->update($data);
                break;
            }
            case -1:// 删除
            {
                break;
            }

            default:
            {
            }
        }

        // return false;
    }
}
