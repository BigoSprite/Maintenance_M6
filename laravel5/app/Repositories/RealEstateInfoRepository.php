<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/5/30
 * Time: 9:34
 */

namespace App\Repositories;
use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Container\Container as App;

class RealEstateInfoRepository extends AbstractRepository
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    function model()
    {
        return 'App\Models\RealEstateInfoModel';
    }
}