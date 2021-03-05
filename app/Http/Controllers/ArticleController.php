<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Genre;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return view('index', compact('articles'));
    }

    public function create()
    {
        $genres = Genre::all();
        return view('create', compact('genres'));
    }

    public function store(Request $request)
    {
        // insert
        Article::create([
            'genre_id' => $request->genre_id,
            'penulis' => $request->penulis,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi
        ]);

        return redirect('/create');
    }

    public function edit($id)
    {
        $article = Article::find($id);
        return view('edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        Article::where('id', $id)
            ->update([
                'penulis' => $request->penulis,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ]);
        
        return redirect('/');
    }

    public function destroy($id)
    {
        Article::destroy($id);
        return redirect('/');
    }
}
