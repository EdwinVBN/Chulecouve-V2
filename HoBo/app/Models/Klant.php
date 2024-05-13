<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klant extends Model
{
    protected $table = 'klant';
    protected $fillable = ['AboID', 'Voornaam', 'Tussenvoegsel', 'Achternaam', 'Email', 'password', 'Genre'];
}
