<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedVerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
    /**
     * The name of the queue connection to use.
     *
     * @var string|null
     */
    public $connection = 'sync';

    /**
     * The name of the queue on which to place the notification.
     *
     * @var string|null
     */
    public $queue = 'default';

    /**
     * The time (seconds) before the job should be processed.
     *
     * @var int
     */
    public $delay = 0;

}