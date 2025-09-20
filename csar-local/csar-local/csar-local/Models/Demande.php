<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'prenom', 'email', 'telephone', 'objet', 'description', 'pj', 'consentement'
    ];
}
