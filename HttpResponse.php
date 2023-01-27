<?php

require "vendor/autoload.php";


class HttpResponse
{
    protected $response;

    public function __construct($response)
    {
        $this->response = $response;
    }

    public function getStatusCode(): int
    {
        return (int) $this->response->getStatusCode();
    }

    public function getBody(): string
    {
        return (string) $this->response->getBody();
    }

    public function toObject(): object
    {
        $body = (string) $this->response->getBody();
        return json_decode($body) ?? (object) [];
    }

    public function toArray(): array
    {
        $body = (string) $this->response->getBody();
        return json_decode($body, true) ?? [];
    }
}