<?php

namespace App\Setup;

class Env
{
    public static function load(string $dir): void
    {
        if (file_exists($dir . '/.env')) {
            $lines = file($dir . '/.env');

            foreach ($lines as $line) {
                if (!trim($line)) {
                    continue;
                }

                putenv(trim($line));
            }
        }
    }
}
