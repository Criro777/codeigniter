<?php

class AuthModel extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function validation_register($username, $email, $password)
    {
        $errorsRegister = [];


        if (strlen($username) <= 2 or $username == '') {

            $errorsRegister[] = 'Имя не должно быть короче 2-х символов';
        }
        if (strlen($password) <= 6 or $password == '') {

            $errorsRegister[] = 'Пароль не должен быть короче 6-ти символов';
        }

        if ($email == '') {

            $errorsRegister[] = 'Введите корректный email';
        }

        if (self::checkEmailExists($email)) {

            $errorsRegister[] = 'Такой email уже используется';
        }


        return $errorsRegister;
    }

    public function validation_login($email, $password)
    {
        $errorsLogin = [];

        if (empty(self::checkUserExists($email, $password))) {
            $errorsLogin[] = 'Пользователь не найден';
        }

        return $errorsLogin;
    }

    public function register_user($username, $email, $password)
    {
        $data['username'] = $username;
        $data['email']    = $email;
        $data['password'] = crypt($password, "salt");
        $this->db->insert('users', $data);

        return  $this->db->insert_id();
    }

    public function checkEmailExists($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);

        $query = $this->db->get();

        $result = $query->result_array();

        return (count($result) != 0);
    }

    public function checkUserExists($email, $password)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('email', $email);
        $this->db->where('password', crypt($password, "salt"));

        $query = $this->db->get();

        $result = $query->result_array();

        return $result[0];

    }

}