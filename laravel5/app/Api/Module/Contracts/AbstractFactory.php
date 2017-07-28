<?php

namespace App\Api\Module\Contracts;

/**
 * 抽象工厂类
 *
 * 该设计模式实现了设计模式的依赖倒置原则，因为最终由具体子类创建具体组件
 *
 * 在本例中，抽象工厂为创建加密器产品提供了接口，这里有一个组件：encrypt加密器
 *
 * 尽管目前只有一个具体的产品，但是客户端只需要知道这个接口可以用于构建加密器，无需关心其具体实现。
 */
abstract class AbstractFactory
{
    abstract public function createEncrypt();
}