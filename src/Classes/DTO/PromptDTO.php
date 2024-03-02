<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\DTO;

final class PromptDTO
{
    private string $promptText = 'Ответь в процентном соотношении в сдедующем формате json и только в таком это очень важно {"percent":"int"} насколько резуюме соответствует вакансии.';
    private string $vacancyText = "";
    private string $candidateResumeText = "";

    /**
     * @param string $vacancyText
     * @param string $candidateResumeText
     */
    public function __construct(string $vacancyText, string $candidateResumeText)
    {
        $this->vacancyText = $vacancyText;
        $this->candidateResumeText = $candidateResumeText;
    }

    /**
     * @return string
     */
    public function getVacancyText(): string
    {
        return $this->vacancyText;
    }

    /**
     * @return string
     */
    public function getCandidateResumeText(): string
    {
        return $this->candidateResumeText;
    }

    public function getAllText(): string
    {
        return $this->promptText . " Вакансия:\n" . $this->vacancyText . "\n Резюме:\n" . $this->candidateResumeText;
    }


}