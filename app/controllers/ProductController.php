<?php

class ProductController
{
    public function index() {

        return view('products.index');
    }

    public function create()
    {
        return view("products.create");
    }
}
