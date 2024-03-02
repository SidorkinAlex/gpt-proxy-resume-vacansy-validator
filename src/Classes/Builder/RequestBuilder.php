<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Builder;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Configs\ApplicationConfig;
use Sidalex\CandidateVacancyEstimationGpt\Classes\DTO\GptRequest;
use Sidalex\CandidateVacancyEstimationGpt\Classes\DTO\PromptDTO;
use Yurun\Util\Swoole\Guzzle\SwooleHandler;

class RequestBuilder
{
    private ApplicationConfig $config;
    private $client_handler;
    private PromptDTO $promptDTO;


    public function __construct(ApplicationConfig $config, PromptDTO $dtoPrompt)
    {
        $this->config = $config;
        $this->client_handler = new SwooleHandler();;
        $this->promptDTO = $dtoPrompt;
    }


    /**
     * @throws GuzzleException
     */
    public function requestBuild(): \Psr\Http\Message\ResponseInterface
    {
        $clientConfig = $this->clientConfigBuild();
        $client = new Client($clientConfig);
        $headers = [
            'Cache-Control: no-cache',
            'Connection: keep-alive',
            'Origin: http://185.251.38.98:81',
            'Pragma: no-cache',
            'Referer: http://185.251.38.98:81/chat/',
            'accept: text/event-stream',
            'content-type: application/json'
        ];
        $gptRequest = new GptRequest($this->promptDTO->getAllText());
        $request_body = json_encode($gptRequest, JSON_UNESCAPED_UNICODE);
        $uri = $this->config->getUrlGpt() . '/backend-api/v2/conversation';
        $psrRequest = new Request("POST", $uri, $headers, $request_body);
        return $client->send($psrRequest);
    }

    private function clientConfigBuild(): array
    {
        /** @phpstan-ignore-next-line */
        $stack = HandlerStack::create($this->client_handler);
        $clientConfig = [
            'handler' => $stack,
            'http_errors' => false,
            'allow_redirects' => false,
            'auth' => ['user1', 'cbsEAL12eMBjnTZQ'],
        ];
        if (!empty($this->config->getAuth())) {
            $clientConfig['auth'] = [$this->config->getAuth()['user'], $this->config->getAuth()['password']];
        }
        return $clientConfig;
    }
}