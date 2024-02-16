<?php

namespace App\Models;

use Config\Database;

class UserModel {
    private $conn;

    public function __construct() {
        require_once '../app/config/database.php';
        $this->conn = Database::connect();
    }

    // CRUD And stuff bulk
    // Create a new user
    public function createUser($data) {
        // echo "creating user <br>";
        $sql = "INSERT INTO users (username, email, password, birthdate, phone_number, url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $data['username'], $data['email'], $data['password'], $data['birthdate'], $data['phone_number'], $data['url']);
        return $stmt->execute();
    }

    // Read user by username
    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    // Update user by username
    public function updateUser($username, $data) {
        $sql = "UPDATE users SET email = ?, password = ?, birthdate = ?, phone_number = ?, url = ? WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssssss", $data['email'], $data['password'], $data['birthdate'], $data['phone_number'], $data['url'], $username);
        return $stmt->execute();
    }

    // Delete user by username
    public function deleteUser($username) {
        $sql = "DELETE FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("s", $username);
        return $stmt->execute();
    }

    // Retrieve all users with specific projection fields
    public function getAllUsers($projection) {
        // Ensure projection fields are valid and not empty
        if (empty($projection) || !is_array($projection)) {
            return false;
        }

        // Construct the SQL query based on the projection fields
        $fields = implode(', ', $projection);
        $sql = "SELECT $fields FROM users";

        // Prepare and execute the query
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        // Fetch all results
        $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

        return $results;
    }

}