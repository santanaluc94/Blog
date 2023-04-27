<?php

namespace App\Controller\Admin;

interface PostInterface
{
    public static function sanitizeFields(array &$data);
}
