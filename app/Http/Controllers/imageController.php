<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Database\QueryException;

class imageController extends Controller
{
    public function sendimage(){
        try{
        return response()->file(public_path("/storage/images/168615106801 gettyimages-1056806292_resized.jpg"));
    }catch(QueryException $e){
        return response()->json($e,500);
      }catch(Exception $e){
        return response()->json($e,500);
      }
    }
}
