<?php
namespace Sidalex\CandidateVacancyEstimationGpt\Classes\DTO;
class Meta
{
    public $id = '7341721389963170797';
    public Content $content;

    /**
     * @param Content $content
     */
    public function __construct(string $question)
    {
        $this->id = (string)microtime(true);
        $this->id = str_replace('.','',$this->id);
        $this->content = new Content($question);
    }

}
