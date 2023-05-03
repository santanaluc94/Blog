<?php

namespace App\Model;

use Exception;

class Db
{
    protected const FILE_NAME = 'db_dump.sql';

    public function deleteOldFile(): void
    {
        unlink($_SERVER['PWD'] . '/public/' . self::FILE_NAME);
    }

    public function isFileExist(): bool
    {
        if (
            isset($_SERVER['PWD']) &&
            file_exists($_SERVER['PWD'] . '/public/') &&
            file_exists($_SERVER['PWD'] . '/public/' . self::FILE_NAME)
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

        $database = getenv('DB_NAME');
        $host = getenv('DB_IP_ADDRESS');
        $user = getenv('DB_USER');
        $password = getenv('DB_PASSWORD');
        $fileName = self::FILE_NAME;

        $query = "mysqldump -h{$host} -u{$user} -p{$password} {$database} > public/{$fileName}";
        system($query);

        if (!$this->isFileExist()) {
            throw new Exception("Não foi possível exportar o banco de dados.", 400);
        }

        return file($_SERVER['PWD'] . '/public/' . self::FILE_NAME);
    }
}
