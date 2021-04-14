<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Article;
use App\Genre;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionMail;
use Validator;

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
        $message = array(
            'penulis.required' => 'nama penulis harus diisi.',
            'penulis.size' => 'nama penulis harus 5 karakter.',
            'judul.required' => 'judul harus diisi.',
            'deskripsi.required' => 'deskripsi harus diisi.'
        );

        $request->validate([
            'penulis' => 'required|size:5',
            'judul' => 'required',
            'deskripsi' => 'required'
        ], $message);

        // insert
        $image = $request->file('image');
        $new_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/images'), $new_name);

        Article::create([
            'genre_id' => $request->genre_id,
            'penulis' => $request->penulis,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $new_name
        ]);

        return redirect('/')->with('success', 'Data Success');
    }

    public function edit($id)
    {
        $article = Article::find($id);
        return view('edit', compact('article'));
    }

    public function update(Request $request, $id)
    {
        $image = $request->file('image');
        $new_name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('storage/images'), $new_name);

        Article::where('id', $id)
            ->update([
                'penulis' => $request->penulis,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'image' => $new_name
            ]);

        return redirect('/');
    }

    public function sendMail(){
        Mail::send(new SubscriptionMail());
    }

    public function destroy($id)
    {
        $image = Article::find($id);
        Storage::delete('images/' . $image->image);
        Article::destroy($id);
        return redirect('/');
    }

    public function apiIndex(){
        $articles = Article::get(['id', 'penulis', 'judul']);
        return response()->json([
            'status' => 200,
            'data' => $articles
        ]);
    }

    public function apiStore(Request $request){
        $validator = Validator::make($request->all(), [
            'genre_id' => 'required',
            'penulis' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 400,
                'errors' => $validator->errors()
            ]);
        }

        Article::create([
            'genre_id' => $request->genre_id,
            'penulis' => $request->penulis,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'image' => $request->image
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil ditambahkan!'
        ]);
    }

    public function apiUpdate(Request $request, $id){
        Article::where('id', $id)
            ->update([
                'penulis' => $request->penulis,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi,
                'image' => $request->image
            ]);

        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diubah!'
        ]);
    }

    public function apiDestroy($id){
        Article::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil dihapus!'
        ]);
    }
}
