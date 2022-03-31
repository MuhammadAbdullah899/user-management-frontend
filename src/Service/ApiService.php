<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ApiService
{
    private $curlRequestService;
    private $session;
    private $backendAppUrl;
    private $clientId;
    private $clientSecret;
    const OAUTH_API_ENDPOINT = '/oauth/v2/token';
    const GRANT_TYPE_PASSWORD = 'password';
    const CREATE = "/register-user";
    const BASE_PATH = "/api/v1/users";
    
    /**
     * ApiService constructor.
     * @param CurlRequestService $curlRequestService
     * @param string $backendAppUrl
     * @param string $clientId
     * @param string $clientSecret
     * @param SessionInterface $session
     */
    public function __construct(
        CurlRequestService $curlRequestService,
        string $backendAppUrl,
        string $clientId,
        string $clientSecret,
        SessionInterface $session
    ) {
        $this->curlRequestService = $curlRequestService;
        $this->backendAppUrl = $backendAppUrl;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->session = $session;
    }
    
    /**
     * @return array
     */
    private function getBody()
    {
        $body['grant_type'] = self::GRANT_TYPE_PASSWORD;
        $body['client_id'] = $this->clientId;
        $body['client_secret'] = $this->clientSecret;
        return $body;
    }
    
    /**
     * @param $accessToken
     * @return string[]
     */
    private function getHeaderFromAccessToken($accessToken)
    {
        return [
            'Authorization: ' . 'Bearer ' . $accessToken
        ];
    }
    
    /**
     * @param string $email
     * @param string $password
     * @return mixed
     */
    public function loginCall(string $email, string $password)
    {
        $body = $this->getBody();
        $body['username'] = $email;
        $body['password'] = $password;
        $response = $this->curlRequestService->sendCURLRequest(
            $this->backendAppUrl . self::OAUTH_API_ENDPOINT,
            CurlRequestService::POST_REQUEST,
            null,
            $body
        );
        
        if (isset($response['code']) && $response['code'] === Response::HTTP_OK && !empty($response['data']['token']['access_token'])) {
            $this->session->set('access_token', $response['data']['token']['access_token']);
            $this->session->set('user', $response['data']['user']);
        }
        return $response;
    }
    
    /**
     * @param $requestBody
     * @return mixed
     */
    public function createUser($requestBody)
    {
        return $this->curlRequestService->sendCURLRequest(
            $this->backendAppUrl . self::CREATE,
            CurlRequestService::POST_REQUEST,
            null,
            $requestBody
        );
    }
    
    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->curlRequestService->sendCURLRequest(
            $this->backendAppUrl . self::BASE_PATH,
            CurlRequestService::GET_REQUEST,
            $this->getHeaderFromAccessToken($this->session->get('access_token'))
        );
    }
}
