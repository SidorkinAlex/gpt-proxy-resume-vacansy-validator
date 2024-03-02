<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Builder;

class RequestToGPTBuilder
{
    public function build(){
        $g = '{
    "action": "_ask",
    "model": "gpt-4-turbo-stream-you",
    "jailbreak": "default",
    "meta": {
        "id": "7322001447494789451",
        "content": {
            "conversation": [],
            "internet_access": false,
            "content_type": "text",
            "parts": [
                ' . $t . '
            ]
        }
    }
}';
    }

}