<?php

namespace Sidalex\CandidateVacancyEstimationGpt;

use GuzzleHttp\Exception\GuzzleException;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Builder\ErrorResponseBuilder;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Builder\RequestBuilder;
use Sidalex\CandidateVacancyEstimationGpt\Classes\DTO\PromptDTO;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Modifier\RequestDtoModifier;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\Exceptions\ResponseValidateException;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\RequestDTOValidator;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\ResponseValidator;

class Application
{
private Classes\Configs\ApplicationConfig $config;

    public function __construct()
    {
        $readConfig = file_get_contents(__DIR__."/../config.json");
        try {
            $this->config = new Classes\Configs\ApplicationConfig($readConfig);
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit(1);
        }
    }



    public function execute(\Swoole\Http\Request $request, \Swoole\Http\Response $response)
    {
        $response->setHeader('Content-Type', 'application/json');
        $obj = json_decode($request->getContent());
        try {
            $requestDtoValidator = new RequestDTOValidator($obj);
            $requestDtoValidator->validate();

        } catch (Classes\Validator\Exceptions\RequestValidateException $e) {
            $errorBuilder = new ErrorResponseBuilder($response);
            $response = $errorBuilder->errorResponse($e->getMessage());
        }
        $requestDtoModifier = new RequestDtoModifier($obj);
        $obj= $requestDtoModifier->ModifyRequest();
        $dtoPrompt = new PromptDTO($obj->vacancyText, $obj->candidateResumeText);
        $requestBuilder = new RequestBuilder($this->config,$dtoPrompt);
        try {
            $response_data = $requestBuilder->requestBuild();
            $responseValidator = new ResponseValidator($response_data);
            $result_json_string = $responseValidator->validateResponse();
        } catch (ResponseValidateException $e) {
            $errorBuilder = new ErrorResponseBuilder($response);
            $response = $errorBuilder->errorResponse($e->getMessage(),400,["gptResponse" => $e->getGptResponse()]);
        } catch (GuzzleException $e) {
            $errorBuilder = new ErrorResponseBuilder($response);
            $response = $errorBuilder->errorResponse($e->getMessage());
        }
        $this->swooleBuildResponse($response_data, $response,$result_json_string);
    }

    private function swooleBuildResponse(\Psr\Http\Message\ResponseInterface $response_data, \Swoole\Http\Response &$response,string $result_json_string): void
    {
        $response->setStatusCode($response_data->getStatusCode());
        $response->end($result_json_string);
    }
}