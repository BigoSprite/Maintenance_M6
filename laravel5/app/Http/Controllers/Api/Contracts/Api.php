<?php

namespace App\Http\Controllers\Api\Contracts;

use App\Repositories\Eloquent\AbstractRepository;

abstract class Api
{
    public $repositoryMgr;

    public function __construct(AbstractRepository $repository)
    {
        $this->repositoryMgr = $repository;
    }
}