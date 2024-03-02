<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Modifier;

class RequestDtoModifier
{
    private \stdClass $requestData;

    /**
     * @param \stdClass $requestData
     */
    public function __construct(\stdClass $requestData)
    {
        $this->requestData = $requestData;
    }
    
    public function ModifyRequest(): \stdClass
    {
        $this->requestData->vacancyText = str_replace(["\n", "\t", "\r"], ' ', $this->requestData->vacancyText);
        $this->requestData->vacancyText = str_replace("  ", ' ', $this->requestData->vacancyText);
        $this->requestData->candidateResumeText = str_replace(["\n", "\t", "\r"], ' ', $this->requestData->candidateResumeText);
        $this->requestData->candidateResumeText = str_replace("  ", ' ', $this->requestData->candidateResumeText);
        return $this->requestData;
    }


}