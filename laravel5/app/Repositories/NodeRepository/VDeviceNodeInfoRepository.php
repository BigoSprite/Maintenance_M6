<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/5/30
 * Time: 14:51
 */

namespace App\Repositories\NodeRepository;


use App\Repositories\Eloquent\AbstractRepository;

class VDeviceNodeInfoRepository extends AbstractRepository
{
    function model()
    {
        return 'App\Models\Node\VDeviceNodeInfoModel';
    }

}