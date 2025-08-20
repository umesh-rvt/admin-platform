<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as BaseVerifyEmail;
use Illuminate\Contracts\Queue\ShouldQueue;

class QueuedVerifyEmail extends BaseVerifyEmail implements ShouldQueue
{
}


