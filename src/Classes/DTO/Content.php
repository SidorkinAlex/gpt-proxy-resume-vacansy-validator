<?php
namespace Sidalex\CandidateVacancyEstimationGpt\Classes\DTO;

class Content
{
    public $conversation = [];
    public $internet_access = false;
    public $content_type = 'text';
    public $parts = [];

    /**
     * @param array $parts
     */
    public function __construct(string $question)
    {
        $this->parts[] = [
            "content" => $question,
            "role" => "user"
        ];
    }

}
