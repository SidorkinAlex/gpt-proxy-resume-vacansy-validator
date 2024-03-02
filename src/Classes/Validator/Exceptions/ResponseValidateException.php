<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\Exceptions;

class ResponseValidateException extends \Exception
{
    private $gptResponse;

    /**
     * @return mixed
     */
    public function getGptResponse()
    {
        return $this->gptResponse;
    }

    /**
     * @param mixed $gptResponse
     */
    public function setGptResponse($gptResponse): void
    {
        $this->gptResponse = $gptResponse;
    }


}