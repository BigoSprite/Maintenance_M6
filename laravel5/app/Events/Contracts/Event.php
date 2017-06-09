<?php

namespace App\Events\Contracts;

abstract class Event
{
    /**
     * 触发事件时，发送的消息类型
     * 0-注册事件；1-更新事件；-1-删除事件
     * @var int
     */
    public $MSG_TYPE = 0;

    /**
     * 触发事件时，传递的数据
     * @var array
     */
    public $data = array();

    public function __construct(array $data, int $MSG_TYPE)
    {
        $this->data = $data;
        $this->MSG_TYPE = $MSG_TYPE;
    }
}
