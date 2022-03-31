<?php

namespace App\Service;

class UserService
{
    private $apiService;
    
    /**
     * UserService constructor.
     * @param ApiService $apiService
     */
    public function __construct(ApiService $apiService )
    {
        $this->apiService = $apiService;
    }
    /**
     * @param $data
     * @return mixed
     */
    public function createUser($data)
    {
        return $this->apiService->createUser(json_encode($data));
    }
    
    /**
     * @return mixed
     */
    public function getUsers()
    {
        return $this->apiService->getUsers();
    }
}