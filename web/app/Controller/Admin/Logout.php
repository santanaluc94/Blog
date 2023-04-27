<?php

namespace App\Controller\Admin;

use App\Http\Request;
use App\Model\AdminSession;

class Logout extends AbstractAdminPost
{
    protected static array $aclAreaMandatory = [];

    public static function execute(Request $request): string
    {
        AdminSession::unsetSession();

        return URL;
    }
}
