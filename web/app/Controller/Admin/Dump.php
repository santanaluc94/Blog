<?php

namespace App\Controller\Admin;

use App\View\View;
use App\Http\Request;
use App\Model\Db;
use Exception;

class Dump extends AbstractAdminPage
{
    public static function execute(Request $request): string
    {
        try {
            self::init(self::$aclAreaMandatory);

            $db = new Db();

            if ($request->getQueryParam('generate') == true) {
                $db->generateDump();
                $request->getRouter()->redirect('/admin/dump');
            }

            $arguments = [
                'title' => 'Dump',
                'generateDump' => 'dump?generate=true',
                'urlDump' => 'public/db_dump.sql',
                'isHidden' => $db->isFileExist() ? '' : 'hidden disabled'
            ];

            $content = View::render(
                'dump',
                self::AREA_ADMIN_HOMEPAGE,
                $arguments
            );
        } catch (Exception $exception) {
            // TODO: Implementar Log
            // TODO: Implementar flash messages

            $request->getRouter()->redirect('/admin/login');
        }

        return parent::getAdminPage(
            $arguments['title'],
            $content
        );
    }
}
