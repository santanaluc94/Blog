<?php

namespace App\Controller\Admin;

use App\Http\Request;

abstract class AbstractAdminPost
{
    public const AREA_ADMIN_HOMEPAGE = 'admin';

    abstract public static function execute(Request $request): string;
}
