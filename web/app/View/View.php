<?php

namespace App\View;

class View
{
    public static function render(
        string $viewName,
        string $area = 'front',
        array $arguments = []
    ): string {
        $contentView = self::getContentView($viewName, $area);

        $keys = array_keys($arguments);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, array_values($arguments), $contentView);
    }

    private static function getContentView(
        string $viewName,
        string $area = 'front'
    ): string {
        $file = __DIR__ . '/' . $area . '/' . $viewName . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }
}
