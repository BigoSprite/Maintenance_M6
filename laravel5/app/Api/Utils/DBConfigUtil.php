<?php

namespace App\Api\Utils;
use Illuminate\Support\Facades\Config;/** for visiting config/database.php */

/**
 * 数据库配置工具类
 *
 * 功能：用于动态配置config/database.php中的connections['mysql_client']的数据库信息
 */
class DBConfigUtil
{
    private function __construct()
    {}

    public static function create()
    {
        $instance = new DBConfigUtil();
        if($instance == null){
            return null;
        }
        return $instance;
    }

    public function setClientModelConnection(string $host, string $database, string $username, string $password)
    {
        // 在runtime期间修改config/database.php中的connections['mysql_client']的数据库信息
        Config::set('database.connections.mysql_client.host', $host);
        Config::set('database.connections.mysql_client.database', $database);
        Config::set('database.connections.mysql_client.username', $username);
        Config::set('database.connections.mysql_client.password', $password);
    }
}