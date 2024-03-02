<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Validator;

use Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\Exceptions\RequestValidateException;

class RequestDTOValidator
{
    private \stdClass $request;

    /**
     * @param \stdClass $request
     * @throws RequestValidateException
     */
    public function __construct(mixed $request)
    {
        if($request === false || is_null($request)){
            throw new RequestValidateException("Request is not valid json");
        }
        if(!($request instanceof \stdClass)){
            throw new RequestValidateException("Request is bad servise cann't be json decoded");
        }
        $this->request = $request;
    }

    /**
     * @throws RequestValidateException
     */
    public function validate()
    {
        if (!isset($this->request->vacancyText) || empty($this->request->vacancyText)) {
            throw new RequestValidateException("not found vacancyText property or is empty");
        }
        if (!isset($this->request->candidateResumeText) || empty($this->request->candidateResumeText)) {
            throw new RequestValidateException("not found candidateResumeText property or is empty");
        }
    }

}