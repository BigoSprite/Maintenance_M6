<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/5/30
 * Time: 14:52
 */

namespace App\Repositories\NodeRepository;


use App\Repositories\Eloquent\AbstractRepository;

class RealEstateInfoRepository extends AbstractRepository
{
    function model()
    {
        return 'App\Models\Node\RealEstateInfoModel';
    }
}