<?php

namespace App\Http\Controllers\Api;
use Illuminate\Container\Container as App;

class ApiInstanceFactory
{
    /**
     * @param $__CLASS_NAME__
     * @param $__REPOSITORY__
     * @param $__REPOSITORY_NAME_SPACE__
     * @param string $__NAME_SPACE__, default __NAMESPACE__
     * @return mixed
     *
     * @NOTE 魔术常量__NAMESPACE__表示$__CLASS_NAME__的当前命名空间
     *
     */
    public static function CREATE_FUNC(
        $__CLASS_NAME__,
        $__REPOSITORY__,
        $__REPOSITORY_NAME_SPACE__,
        $__NAME_SPACE__ = __NAMESPACE__)
    {
        $className = $__NAME_SPACE__.'\\'.ucfirst($__CLASS_NAME__);

        $repositoryClassName = $__REPOSITORY_NAME_SPACE__.'\\'.ucfirst($__REPOSITORY__);
        $repositoryMgr = new $repositoryClassName(App::getInstance());

        if (!class_exists($className)) {
            throw new \InvalidArgumentException('Missing api class.');
        }

        if (!class_exists($repositoryClassName)) {
            throw new \InvalidArgumentException('Missing repository class.');
        }

        return new $className($repositoryMgr);
    }
}