<?php

namespace Infinety\TemplyResourcesSelector\Events;

use Illuminate\Queue\SerializesModels;

class ResourceChangedEvent
{
    use SerializesModels;

    /**
     * @var mixed
     */
    public $type;

    /**
     * @var mixed
     */
    public $status;

    /**
     * Create a new event instance.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function __construct($type, $status)
    {
        $this->type = $type;
        $this->status = $status;
    }
}
