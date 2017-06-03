<?php
/**
 * Created by PhpStorm.
 * User: fm
 * Date: 2017/6/2
 * Time: 15:08
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\Contracts\Api;
use App\Http\Controllers\Api\Utils\ApiInstanceFactory;
use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Container\Container as App;

class UserApi extends Api
{
    public function __construct(AbstractRepository $repository)
    {
        parent::__construct($repository);
    }

    public static function create()
    {
       return ApiInstanceFactory::CREATE_FUNC('UserApi', 'UserInfoRepository',
           'App\Repositories');
    }

    public function all()
    {
        $modelArray = $this->repositoryMgr->all();

        $data = array();

        foreach ($modelArray as $item) {
            $tmp = [
                'username' => $item->userName,
                'loginPassword' => $item->loginPassword
            ];

            $data[] = $tmp;
        }
        return ['data'=>$data];
    }

}