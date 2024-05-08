<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genre';
    protected $primaryKey = 'GenreID';

    public function series() {
        return $this->belongsToMany(Serie::class, 'serie_genre', 'GenreID', 'SerieID');
    }
}
