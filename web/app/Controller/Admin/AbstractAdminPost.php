<?php

namespace App\Controller\Admin;

use App\Http\Request;

abstract class AbstractAdminPost extends AbstractAdmin
{
    abstract public static function execute(Request $request): string;
}
