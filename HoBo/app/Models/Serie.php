<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'serie';
    protected $primaryKey = 'SerieID';

    protected $fillable = [
        'SerieID',
        'SerieTitel',
        'IMDBLink',
        'Image',
        'Actief',
        'Description',
        'Director',
        'IMDBrating',
        'trailerVideo'
    ];

    public function seasons() {
        return $this->hasMany(Seizoen::class, 'serieID');
    }

    public function genres() {
        return $this->belongsToMany(Genre::class, 'serie_genre', 'SerieID', 'GenreID');
    }

    public function episodes()
    {
        return $this->hasManyThrough(
            Aflevering::class, 
            Seizoen::class,  
            'SerieID',     
            'SeizID',    
            'SerieID',           
            'SeizoenID'           
        );
    }
}
