<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['genre_id', 'penulis', 'judul', 'deskripsi'];

    public function genre(){
        return $this->belongsTo('App\Genre');
    }
}
