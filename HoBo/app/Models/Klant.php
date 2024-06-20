<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Klant extends Authenticatable
{
    protected $table = 'klant';
    public $timestamps = false;
    protected $primaryKey = 'KlantNr'; // Replace 'klantNr' with the name of your primary key column

    public function getAuthIdentifier()
    {
        return $this->KlantNr;
    }

    public static $rules = [
        'Email' => 'required|string|email|max:36|unique:klant,Email,{$this->KlantNr},KlantNr',
    ];

    protected $fillable = [
        'Email',
        'Naam',
        'password',
        'totalWatched',
        'expiration_time'
        // Add other fields here
    ];
}