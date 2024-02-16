<?php

namespace App\Controllers;

use App\Models\UserModel;
class UserController
{
    private $userModel;

    public function __construct()
    {
        require_once '../app/models/UserModel.php';
        $this->userModel = new UserModel();
    }

    public function index()
    {
        include '../app/views/user/create-user.php';
    }

    // POST operation to insert a new user
    public function post()
    {
        // // POST data from a form or JSON from API
         // Check if the request is a JSON request
        $isJsonRequest = ($_SERVER['CONTENT_TYPE'] === 'application/json');
        // Get the request body
        $requestBody = ($isJsonRequest) ? file_get_contents('php://input') : '';

        // Decode JSON data if it's a JSON request
        $jsonData = ($isJsonRequest) ? json_decode($requestBody, true) : [];

        // Use form data if it's not a JSON request
        $postData = ($isJsonRequest) ? $jsonData : $_POST;
        // Validate POST data as needed
        $validationErrors = $this->validateUserData($postData);
        if (!empty($validationErrors)) {
            // var_dump($validationErrors);
            http_response_code(400);
            // Output error message
            echo json_encode(['error' => $validationErrors]);
    
            include '../app/views/user/create-user.php';
            return;
        }
        // Call the UserModel method to create a new user
        $success = $this->userModel->createUser($postData);

        if ($success) {
            include '../app/views/user/create-user.php';
        } else {
            http_response_code(400);
            echo "db creation failed";
        }
    }

    public function getAllUsers()
    {
        $users = $this->userModel->getAllUsers(['username', 'email']);
        include '../app/views/user/users-table.php';
    }

    //api to get all users
    public function getAllUsersList()
    {
        $users = $this->userModel->getAllUsers(['username', 'email']);
        echo json_encode($users);
        return;
    }
    // Method to delete a user post request
    public function deleteUser() {
         // POST data from a form or JSON from API
         // Check if the request is a JSON request
         $isJsonRequest = ($_SERVER['CONTENT_TYPE'] === 'application/json');
         // Get the request body
         $requestBody = ($isJsonRequest) ? file_get_contents('php://input') : '';
 
         // Decode JSON data if it's a JSON request
         $jsonData = ($isJsonRequest) ? json_decode($requestBody, true) : [];
 
         // Use form data if it's not a JSON request
         $postData = ($isJsonRequest) ? $jsonData : $_POST;
        // Call the deleteUser method from the UserModel passing the username
        $deleted = $this->userModel->deleteUser($postData['username']);
        $users = $this->userModel->getAllUsers(['username', 'email']);
        if (!$deleted) {
            http_response_code(400);
        }
        include '../app/views/user/users-table.php';
    }

    public function getUserDetails($params) {
        $details = $this->userModel->getUserByUsername($params['username']);
        // var_dump($details);
        echo json_encode($details);
        return;
    }

    public function test()
    {
        $inputData = [
            'username' => 'roni_l', 
            'email' => 'roni@example.com',
            'password' => '123456',
            'birthdate' => '1990-08-09', 
            'phone_number' => '+542387689', 
            'url' => 'http://example.com' 
        ];

        $result = $this->userModel->createUser($inputData);

        if ($result) {
            echo "User created successfully!";
        } else {
            echo "Failed to create user.";
        }

    }

    // Validate user data
    private function validateUserData($data)
    {
        $errors = [];

        // Username validation - letters only
        if (empty($data['username']) || !preg_match("/^[a-zA-Z]+$/", $data['username'])) {
            $errors[] = "Username must contain letters only.";
        }
        // Email validation - email format
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email format.";
        }

        // Password validation - 8 chars min, 1 lowercase, 1 uppercase, 1 special sign
        if (
            empty($data['password']) || strlen($data['password']) < 8 ||
            !preg_match("/[a-z]/", $data['password']) ||
            !preg_match("/[A-Z]/", $data['password']) ||
            !preg_match("/[!@#$%^&*()\-_=+{};:,<.>]/", $data['password'])
        ) {
            $errors[] = "Password must be at least 8 characters long and contain at least one lowercase letter, one uppercase letter, and one special character.";
        }

        // Birthday validation - 'YYYY-MM-DD' format
        if (!empty($data['birthdate'])) {
            $birthdate = \DateTime::createFromFormat('Y-m-d', $data['birthdate']);
            if ($birthdate === false || $birthdate->format('Y-m-d') !== $data['birthdate']) {
                $errors[] = "Invalid birthday format. Use 'YYYY-MM-DD'.";
            }
        }

        // URL validation - valid URL structure
        if (!empty($data['url']) && !filter_var($data['url'], FILTER_VALIDATE_URL)) {
            $errors[] = "Invalid URL format.";
        }

        // Phone Number validation - only numbers and 10 characters
        if (!empty($data['phone_number']) && !preg_match("/^\d{10}$/", $data['phone_number'])) {
            $errors[] = "Phone number must contain only numbers and be 10 characters long.";
        }

        return $errors;
    }

}