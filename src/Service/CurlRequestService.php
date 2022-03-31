<?php

namespace App\Service;

/**
 * Class CurlRequestService
 * @package App\Service
 */
class CurlRequestService
{
    const GET_REQUEST = 'GET_REQUEST';
    const POST_REQUEST = 'POST_REQUEST';
    const PUT_REQUEST = 'PUT_REQUEST';
    const DELETE_REQUEST = 'DELETE_REQUEST';
    
    const REQUEST_TYPES = [
        'GET_REQUEST' => 'GET',
        'POST_REQUEST' => 'POST',
        'PUT_REQUEST' => 'PUT',
        'DELETE_REQUEST' => 'DELETE'
    ];
    
    /**
     * @param string $uri
     * @param string $requestType
     * @param array|null $header
     * @param null $requestBody
     * @return mixed
     */
    public function sendCURLRequest(
        string $uri,
        string $requestType,
        array $header = null,
        $requestBody = null
    ) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uri);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::REQUEST_TYPES[$requestType]);
        
        if ($requestBody) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
        }
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $result = curl_exec($ch);
        return json_decode($result, true);
    }
}
