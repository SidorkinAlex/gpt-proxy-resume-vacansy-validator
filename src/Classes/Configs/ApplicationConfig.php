<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Configs;

class ApplicationConfig
{
    private  string $urlGpt;
    private array $auth;


    public function __construct(string $dataJson)
    {
        $obj = json_decode($dataJson);

        if(
            !($obj instanceof \stdClass) &&
            !isset($obj->urlGpt) &&
            !isset($obj->auth->user) &&
            !isset($obj->auth->password)
        ){
            throw new \Exception("config.json is not a valid ");
        }

        $this->urlGpt = $obj->urlGpt;
        $this->auth['user'] = $obj->auth->user;
        $this->auth['password'] = $obj->auth->password;
    }

    /**
     * @return string
     */
    public function getUrlGpt(): string
    {
        return $this->urlGpt;
    }

    /**
     * @return array
     */
    public function getAuth(): array
    {
        return $this->auth;
    }


}