<?php

namespace App\Http;

class Response
{
    private const CONTENT_TYPE = 'Content-Type';

    public function __construct(
        protected int $httpCode,
        protected string $content,
        protected string $contentType = 'text/html',
        protected array $headers = []
    ) {
        $this->addHeaders(self::CONTENT_TYPE, $contentType);
    }

    public function addHeaders(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function sendResponse(): void
    {
        http_response_code($this->httpCode);

        switch ($this->contentType) {
            case 'text/html':
                echo $this->content;
                break;
            case 'application/x-httpd-php':
                header("Location: {$this->content}");
                exit();
                break;
        }
    }
}
