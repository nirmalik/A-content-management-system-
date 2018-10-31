<?php

class Admin {

    public $id;
    public $name;
    public $role;
    public $phone;
    public $email;
    public $image;
    public $password;

    function __construct($id, $name, $phone, $email, $image, $role, $password) {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
        $this->phone = $phone;
        $this->email = $email;
        $this->image = $image;
        $this->password = $password;
    }

}
