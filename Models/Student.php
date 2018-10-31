<?php

class Student {

    public $id;
    public $name;
    public $phone;
    public $email;
    public $image;

    function __construct($id, $name, $phone, $email, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->email = $email;
        $this->image = $image;
    }

}
