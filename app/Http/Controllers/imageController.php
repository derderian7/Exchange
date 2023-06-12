<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class imageController extends Controller
{
    public function sendimage(){
        return response()->file(public_path("/storage/images/168615106801 gettyimages-1056806292_resized.jpg"));
    }
}
