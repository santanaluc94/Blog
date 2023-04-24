<?php

namespace App\View;

class View
{
    protected static array $arguments = [];

    public static function render(
        string $viewName,
        string $area = 'front',
        array $arguments = []
    ): string {
        $contentView = self::getContentView($viewName, $area);

        $arguments = array_merge(self::$arguments, $arguments);

        $keys = array_keys($arguments);
        $keys = array_map(function ($item) {
            return '{{' . $item . '}}';
        }, $keys);

        return str_replace($keys, array_values($arguments), $contentView);
    }

    public static function init(array $arguments = []): void
    {
        self::$arguments = $arguments;
    }

    private static function getContentView(
        string $viewName,
        string $area = 'front'
    ): string {
        $file = __DIR__ . '/' . $area . '/' . $viewName . '.html';
        return file_exists($file) ? file_get_contents($file) : '';
    }
}
