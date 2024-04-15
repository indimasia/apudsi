<?php

use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->add('general.notify_registration_email_list', 'ucilxsade@gmail.com');
    }
};
