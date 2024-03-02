<?php

namespace Sidalex\CandidateVacancyEstimationGpt\Classes\Validator;

use Psr\Http\Message\ResponseInterface;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\Exceptions\RequestValidateException;
use Sidalex\CandidateVacancyEstimationGpt\Classes\Validator\Exceptions\ResponseValidateException;

class ResponseValidator
{
    private string $pattern = '
/
\{              # { character
    (?:         # non-capturing group
        [^{}]   # anything that is not a { or }
        |       # OR
        (?R)    # recurses the entire pattern
    )*          # previous group zero or more times
\}              # } character
/x
';
    private \Psr\Http\Message\ResponseInterface $response_data;

    /**
     * @param ResponseInterface $response_data
     */
    public function __construct(\Psr\Http\Message\ResponseInterface $response_data)
    {
        $this->response_data = $response_data;
    }


    /**
     * @throws ResponseValidateException
     */
    public function validateResponse():string{
        $matches=[];
        preg_match_all($this->pattern, $this->response_data->getBody(), $matches);
        $valid_jsons_arr = array_filter($matches[0], 'isValidJSON');
        $result_json_string='';
        if(isset($valid_jsons_arr[0])){
            $result_json_string = $valid_jsons_arr[0];
         } else {
            $e = new ResponseValidateException("valid json string in response not found in gpt response");
            $e->setGptResponse((string)$this->response_data->getBody());
            throw $e;
        }

        return $result_json_string;
    }
}