<?php

namespace App\Events;

use App\Events\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RealEstateInfoChanged extends Event
{
    use SerializesModels;

    /**
     * 传输过来的数据
     *
     * @var array
     */
    public $realEstateData = array();

    /**
     * 事件的类型
     * 0-注册事件；1-更新事件；-1-删除事件
     *
     * @var int
     */
    public $type = 0;

    public function __construct(array $data, int $type)
    {
        $this->realEstateData = $data;
        $this->type = $type;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
