<?php

namespace App\Api\Utils;

use Illuminate\Database\Connection; /** for Connection */


/** Database Connector---Singleton */
class DBDirector
{
    /**
     * @var Singleton reference to singleton instance
     */
    private static $__instance = null;

    /**
     * 通过延迟加载（用到时才加载）获取实例
     *
     * @return self
     */
    public static function getInstance(){
        if(self::$__instance == null){
            self::$__instance = new DBDirector();
        }
        return self::$__instance;
    }

    /**
     * 构造函数私有，不允许在外部实例化
     */
    private function __construct()
    {
    }

    /**
     * 防止对象实例被克隆
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * 防止被反序列化
     *
     * @return void
     */
    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public function connection($dbIp, $database, $user, $password)
    {
        $dsn = "mysql:host={$dbIp};dbname={$database}";
        $db = null;
        try{
            $db = new \PDO($dsn, $user, $password);
        }catch (\PDOException $exception){

            die("Error, " . $exception->getMessage() . "<br/>");
//            return null;
        }

        $con = new Connection($db);
        return $con;
    }

    public function connection_Ex(array $data)
    {
        $dbIp = $data['dbIp'];
        $dbPort = $data['dbPort'];
        $database = $data['dbName'];
        $user = $data['dbUserName'];
        $password = $data['dbPassword'];

        return $this->connection($dbIp, $database, $user, $password);
    }
}