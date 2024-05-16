<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Klant extends Authenticatable
{
    use HasFactory;
    protected $table = 'klant';
    protected $fillable = ['AboID', 'Username', 'Voornaam', 'Tussenvoegsel', 'Achternaam', 'Email', 'password', 'Genre', 'Iban', 'adress'];

    protected $primareyKey = 'KlantNr';

    public function getAuthIdentifierName()
    {
        return 'KlantNr'; // Assuming your primary key column is named 'id'
    }

    public function getAuthIdentifier()
    {
        return $this->KlantNr; // Assuming your primary key column is named 'id'
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}

