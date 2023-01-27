<?php

require "vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;


class Build
{
    protected ClientInterface $http;

    protected array $options = [];

    CONST logName = 'Api';
    CONST logFile = 'ApiRecord.log';

    public function __construct()
    {
        $this->http = new Client([
            'handler' => $this->loggered()
        ]);
    }

    public function loggered()
    {
        $logger = new Logger(self::logName);
        $logger->pushHandler(new StreamHandler(__DIR__ . '/'. self::logFile));

        $stack = HandlerStack::create();
        $stack->push(Middleware::log(
            $logger,
            new MessageFormatter('{req_body} - {res_body}')
        ));
        return $stack;
    }

    public static function connection(): self
    {
        return new static();
    }

    public function baseUrl(string $url): self
    {
        $this->options['base_uri'] = $url;
        return $this;
    }

    public function query(array $parameters): self
    {
        $this->options['query'] = $parameters;
        return $this;
    }

    public function get(string $url): HttpResponse
    {
        return $this->send('GET', $url);
    }

    public function httpStatus()
    {
        $this->options['http_errors'] = false;
        return $this;
    }

    protected function send(string $method, string $url): HttpResponse
    {
        try {
            $response = $this->http->request($method, $url, $this->options);
            return new HttpResponse($response);
        }catch (\GuzzleHttp\Exception\ClientException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            return $responseBodyAsString;
        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            $response = $e->getResponse();
            return $response;
        }
    }


}

