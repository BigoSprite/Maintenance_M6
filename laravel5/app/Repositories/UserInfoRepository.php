<?php

namespace App\Repositories;

use App\Repositories\Eloquent\AbstractRepository;
use Illuminate\Container\Container as App;

class UserInfoRepository extends AbstractRepository
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    function model()
    {
        return 'App\Models\UserInfoModel';
    }
}