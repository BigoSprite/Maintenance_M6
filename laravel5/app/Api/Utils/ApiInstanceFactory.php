<?php

namespace App\Api\Utils;
use Illuminate\Container\Container as App;

class ApiInstanceFactory
{
    /**
     * Cocos2d-x style CREATE_FUNC
     *
     * @param $__CLASS_NAME__
     * @param string $__CLASS_NAME_SPACE__
     * @param $__REPOSITORY__
     * @param $__REPOSITORY_NAME_SPACE__
     * @return mixed
     */
    public static function CREATE_FUNC(
        $__CLASS_NAME__,
        $__CLASS_NAME_SPACE__,
        $__REPOSITORY__,
        $__REPOSITORY_NAME_SPACE__)
    {
        $className = $__CLASS_NAME_SPACE__.'\\'.ucfirst($__CLASS_NAME__);
        if (!class_exists($className)) {
            throw new \InvalidArgumentException('Missing api class.');
        }

        $repositoryClassName = $__REPOSITORY_NAME_SPACE__.'\\'.ucfirst($__REPOSITORY__);
        if (!class_exists($repositoryClassName)) {
            throw new \InvalidArgumentException('Missing repository class.');
        }
        $repositoryMgr = new $repositoryClassName(App::getInstance());

        return new $className($repositoryMgr);
    }
}