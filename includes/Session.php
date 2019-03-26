<?php

class Session
{
    private $logged_in = false;

    public function __construct()
    {
        session_start();
        $this->checkLogin();
    }

    private function checkLogin()
    {
        if (isset($_SESSION['logged_in'])) {
            $this->logged_in = true;
        }
    }

    public function is_logged_in()
    {
        return $this->logged_in;
    }

    public function logout()
    {
        unset($_SESSION['logged_in']);
        $this->logged_in = false;
        header('Location: ../');
    }
}
