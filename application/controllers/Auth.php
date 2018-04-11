<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('authModel');
        session_start();
        //$this->load->library('session');
    }

    public function login()
    {
        if (! isset($_SESSION['username'])) {

            $this->load->view('login');

            unset($_SESSION['errors']);

            unset($_SESSION['success']);

            if (isset($_POST['login'])) {

                $email    = $this->input->post('email');
                $password = $this->input->post('password');

                $auth = $this->authModel->validation_login($email, $password);

                if (count($auth) != 0) {

                    $_SESSION['errors'] = $auth;

                    header("Location:/login");

                } else {
                    $currentUser = $this->authModel->checkUserExists($email, $password);

                    $_SESSION['username'] = $currentUser['username'];
                    $_SESSION['userId']   = $currentUser['id'];

                    header('Location:/');

                    //$this->load->view('main');
                }


            }

        } else header('Location:/');
    }

    public function register()
    {
        if (! isset($_SESSION['username'])) {

            $this->load->view('register');

           unset($_SESSION['errors']);

            if (isset($_POST['register'])) {

                $username = $this->input->post('username');
                $email    = $this->input->post('email');
                $password = $this->input->post('password');


                $validation = $this->authModel->validation_register($username, $email, $password);

                if (count($validation) != 0) {

                    $_SESSION['errors'] = $validation;
                    header('Location:/register');

                } else {
                    $success = $this->authModel->register_user($username, $email, $password);
                    $_SESSION['success'] = $success;
                    header('Location:/login');
                }

            }
        } else {
            header('Location:/');
        }
    }

    public function logout()
    {
        unset($_SESSION['username']);
        unset($_SESSION['userId']);

        header("Location: /");
    }

}