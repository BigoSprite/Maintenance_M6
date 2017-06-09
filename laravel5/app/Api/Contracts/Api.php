<?php

namespace App\Api\Contracts;

use App\Api\RealEstateInfoApi;
use App\Api\Utils\DBConfigUtil;
use App\Repositories\Eloquent\AbstractRepository;

abstract class Api
{
    public $repositoryMgr;

    public function __construct(AbstractRepository $repository)
    {
        $this->repositoryMgr = $repository;
    }


    /**
     * 功能：配置数据库
     * @param string $runtimeDatabaseName
     */
    protected static function configureConnection(string $runtimeDatabaseName = "" )
    {
        /** ！！！需要在运行期动态设置数据库的连接 */
        if($runtimeDatabaseName != "")
        {
            $data = RealEstateInfoApi::create()->getRealEstateDBInfo($runtimeDatabaseName);
            $dbInfo = $data['data'];

            if(count($dbInfo) > 0){
                $host = $dbInfo['dbIp'];
                $username = $dbInfo['dbUserName'];
                $password = $dbInfo['dbPassword'];
                DBConfigUtil::create()->setClientModelConnection($host, $runtimeDatabaseName, $username, $password);
            }
        }
    }
}