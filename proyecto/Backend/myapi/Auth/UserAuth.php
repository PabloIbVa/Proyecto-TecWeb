<?php
namespace myapi\Auth;

use myapi\DataBase;

class UserAuth extends DataBase {

    public function getUserByEmail($email) {
        $safeEmail = $this->conexion->real_escape_string($email);
        $sql = "SELECT * FROM user WHERE email = '$safeEmail'";
        $result = $this->conexion->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function getUserById($id) {
        $id = intval($id);
        $sql = "SELECT * FROM user WHERE id = $id";
        $result = $this->conexion->query($sql);
        return $result ? $result->fetch_assoc() : null;
    }

    public function emailAvailable($email) {
        $safeEmail = $this->conexion->real_escape_string($email);
        $sql = "SELECT * FROM user WHERE email = '$safeEmail'";
        $result = $this->conexion->query($sql);
        return $result && $result->num_rows === 0;
    }

    public function registerUser($name, $email, $password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conexion->prepare("INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hash);
        return $stmt->execute();
    }
}
