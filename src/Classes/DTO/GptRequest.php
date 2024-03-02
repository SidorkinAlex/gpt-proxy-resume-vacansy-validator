<?php
namespace Sidalex\CandidateVacancyEstimationGpt\Classes\DTO;
class GptRequest {
    public $action = '_ask';
    public $model = 'gpt-4-turbo-stream-you';
    public $jailbreak = 'default';
    public $conversation_id = '5f827d3d-8646-41a8-b8f5-18dff5b9355';
    public Meta $meta;

    /**
     * @param Meta $meta
     */
    public function __construct(string $question)
    {
        $this->meta = new Meta($question);
    }

}
