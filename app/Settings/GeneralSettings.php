<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class GeneralSettings extends Settings
{
    public string $mobile_version;
    public string $notify_registration_email_list;

    public static function group(): string
    {
        return 'general';
    }
}