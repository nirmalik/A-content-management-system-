<?php


class Course {
   
    public $id;
    public $name;
    public $phone;
    public $description;
    public $image;
    
    function __construct($id, $name, $phone, $description, $image) {
        $this->id = $id;
        $this->name = $name;
        $this->phone = $phone;
        $this->description = $description;
        $this->image = $image;
    }

}
