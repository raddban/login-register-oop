<?php

class User
{
    private $db;
    private $data;
    private $sessionName;
    private $isLoggedIn;

    public function __construct($user = null)
    {
        $this->db = DB::getInstance();

        $this->sessionName = Config::get('session/session_name');

        if (!$user)
        {
            if (Session::exists($this->sessionName))
            {
                $user = Session::get($this->sessionName);

                if ($this->find($user))
                {
                    $this->isLoggedIn = true;
                }
            }
        }else
        {
            $this->find($user);
        }
    }

    public function update($fields = [], $id = null)
    {
        if (!$id && $this->isloggedIn())
        {
            $id = $this->data()->id;
        }
        if (!$this->db->update('users', $id, $fields))
        {
            throw new Exception('There was a problem updating');
        }
    }

    public function create($fields = [])
    {
        if (!$this->db->insert('users', $fields))
        {
            throw new Exception('There was a problem creating an account');
        }
    }

    public function find($user = null)
    {
        if ($user)
        {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->db->get('users', [$field, '=', $user]);

            if ($data->count())
            {
                $this->data = $data->first();
                return true;
            }
        }
        return false;
    }

    public function login($username = null, $password = null)
    {

        $user = $this->find($username);
        if ($user)
        {
            if ($this->data()->password == Hash::make($password))
            {
                Session::put($this->sessionName, $this->data()->id);

                return true;
            }
        }
        return false;
    }

    public function logout()
    {
        Session::delete($this->sessionName);

    }

    public function data()
    {
        return $this->data;
    }

    public function isloggedIn()
    {
        return $this->isLoggedIn;
    }
}