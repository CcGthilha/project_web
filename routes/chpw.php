<?php


if (!isset($_GET['id']) || empty($_GET['id'])) {
    renderView('400', ['message' => 'Something went wrong! Missing user ID']);
    exit;
} else {
    $id = (int)$_GET['id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($password !== $confirm_password) {
            renderView('400', ['message' => 'Password and Confirm Password do not match']);
            exit;
        }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $res = updateUserPassword($id, $hashed_password);
        if ($res > 0) {
            header('Location: /home');
            exit;
        } else {
            renderView('400', ['message' => 'Something went wrong! on update password']);
            exit;
        }
    } else {
        $res = getUserById($id);
        if ($res) {
            renderView('chpw', array('result' => $res));
        } else {
            renderView('400', ['message' => 'Something went wrong! on query user']);
        }
    }
}
