<?php

namespace DamodarBhattarai\Settings\Composer;

use Composer\Script\Event;
use Composer\IO\IOInterface;

class PostInstall
{
    public static function prompt(Event $event)
    {
        $io = $event->getIO();

        $io->write([
            '',
            '<info>Thank you for installing damodar-bhattarai/settings!</info>',
            'If you find this package helpful, please consider giving it a ⭐ on GitHub:',
            '<fg=cyan>https://github.com/damodar-bhattarai/settings</fg>',
            'Your support helps keep this project alive and motivates further development! 😊',
            ''
        ]);
    }
}
