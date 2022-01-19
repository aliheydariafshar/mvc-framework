<?php


namespace App\Http\Controllers;


class HomeController extends Controller
{
    public function index()
    {
        echo "index method in homeController";
    }

    public function create()
    {
        echo "create method in homeController";
    }

    public function store()
    {
        echo "store method in homeController";
    }

    public function edit($id)
    {
        echo "edit method in homeController";
    }

    public function update($id)
    {
        echo "update method in homeController";
    }

    public function destroy($id)
    {
        echo "destroy method in homeController";
    }
}