<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use App\Models\Video;

class NewVideoEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Video details.
     * @var Video
     */
    public $video;

    /**
     * Data to broadcast.
     * @var array
     */
    public $broadcastData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Video $video, array $data)
    {
        $this->video = $video;
        $this->broadcastData = $data;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return $this->broadcastData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('playlist.' . $this->video->play_list_id);
    }
}
