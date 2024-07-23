<?php

namespace App\Containers\Sms\Enums;

enum SmsStatusEnum: string {
    case PENDING   = 'pending';
    case SENT      = 'sent';
    case FAILED    = 'failed';
    case DELIVERED = 'delivered';
}
