<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * 触发成功消息推送到前台
 *
 * Class ToastEvent
 *
 * @package App\Events
 */
class ToastSuccessEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $message;
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @param  int  $user_id
     * @param  string  $message  提示消息
     */
    public function __construct(int $user_id, string $message)
    {
        $this->user_id = $user_id;
        $this->message = $message;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('room.'.$this->user_id);
    }

    /**
     * 广播时间名称
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'toast.success';
    }
}
