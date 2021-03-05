<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Genre;

class GenreController extends Controller
{
    public function index(){
        return view('genre');
    }

    public function store(Request $request){
        Genre::create([
            'name' => $request->genre
        ]);

        return redirect('/genre');
    }
}
