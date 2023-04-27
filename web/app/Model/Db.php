<?php

namespace App\Model;

use PDO;
use PDOStatement;
use Exception;

class Db
{
    public function deleteOldFile(): void
    {
        unlink($_SERVER['PWD'] . '/public/db_dump.sql');
    }

    public function isFileExist(): bool
    {
        if (
            isset($_SERVER['PWD']) &&
            file_exists($_SERVER['PWD'] . '/public/') &&
            file_exists($_SERVER['PWD'] . '/public/db_dump.sql')
        ) {
            return true;
        }

        return false;
    }

    public function generateDump()
    {
        if ($this->isFileExist()) {
            $this->deleteOldFile();
        }

        system(
            'mysqldump -h db' .
                ' -u ' . getenv('DB_USER') .
                ' --database ' . getenv('DB_NAME') . ' > public/db_dump.sql' .
                ' -p ' . getenv('DB_PASSWORD')
        );

        return file($_SERVER['PWD'] . '/public/db_dump.sql');
    }
}
