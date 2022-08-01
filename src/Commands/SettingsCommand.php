<?php

namespace StillAlive\Settings\Commands;

use Illuminate\Console\Command;

class SettingsCommand extends Command
{
    public $signature = 'settings';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
