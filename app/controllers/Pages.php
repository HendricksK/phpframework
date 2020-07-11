<?php

class Pages {

    protected string $name = 'Pages';

    public function __construct() {
        // echo $this->name;
    }

    public function index() {
        echo 'default index';
    }

    public function about($id) {
        echo $id;
    }
}