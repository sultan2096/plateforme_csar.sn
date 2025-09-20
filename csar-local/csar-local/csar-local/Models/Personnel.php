<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personnel extends Model
{
    use HasFactory;

    protected $table = 'personnel';

    protected $fillable = [
        'prenoms_nom',
        'date_naissance',
        'lieu_naissance',
        'tranche_age',
        'nationalite',
        'numero_cni',
        'sexe',
        'situation_matrimoniale',
        'nombre_enfants',
        'contact_telephonique',
        'email',
        'groupe_sanguin',
        'adresse_complete',
        'matricule',
        'date_recrutement_csar',
        'date_prise_service_csar',
        'statut',
        'poste_actuel',
        'direction_service',
        'localisation_region',
        'dernier_poste_avant_csar',
        'formations_professionnelles',
        'diplome_academique',
        'autres_diplomes_certifications',
        'logiciels_maitrises',
        'langues_parlees',
        'autres_aptitudes',
        'aspirations_professionnelles',
        'interet_nouvelles_responsabilites',
        'photo_personnelle',
        'taille_vetements',
        'contact_urgence_nom',
        'contact_urgence_telephone',
        'contact_urgence_lien_parente',
        'observations_personnelles',
        'statut_validation',
        'commentaire_validation',
        'valide_par',
        'date_validation'
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'date_recrutement_csar' => 'date',
        'date_prise_service_csar' => 'date',
        'date_validation' => 'datetime',
        'logiciels_maitrises' => 'array',
        'langues_parlees' => 'array',
        'nombre_enfants' => 'integer'
    ];

    // Relations
    public function validateur()
    {
        return $this->belongsTo(User::class, 'valide_par');
    }

    // Scopes
    public function scopeValides($query)
    {
        return $query->where('statut_validation', 'Validé');
    }

    public function scopeEnAttente($query)
    {
        return $query->where('statut_validation', 'En attente');
    }

    public function scopeParDirection($query, $direction)
    {
        return $query->where('direction_service', $direction);
    }

    public function scopeParPoste($query, $poste)
    {
        return $query->where('poste_actuel', $poste);
    }

    public function scopeParRegion($query, $region)
    {
        return $query->where('localisation_region', $region);
    }

    // Accesseurs
    public function getAgeAttribute()
    {
        return $this->date_naissance->age;
    }

    public function getAncienneteAttribute()
    {
        return $this->date_recrutement_csar->diffInYears(now());
    }

    public function getPhotoUrlAttribute(): string
    {
        $fileName = $this->photo_personnelle;
        if (!empty($fileName)) {
            $relativePath = 'personnel/' . $fileName;
            if (\Illuminate\Support\Facades\Storage::disk('public')->exists($relativePath)) {
                // Retourne une URL RELATIVE pour éviter les soucis de port/APP_URL
                return '/storage/' . $relativePath;
            }
        }
        // Fallback avatar si aucune photo disponible
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->prenoms_nom ?? 'Utilisateur') . '&background=059669&color=ffffff';
    }

    // Méthodes
    public function valider($userId, $commentaire = null)
    {
        $this->update([
            'statut_validation' => 'Validé',
            'valide_par' => $userId,
            'date_validation' => now(),
            'commentaire_validation' => $commentaire
        ]);
    }

    public function rejeter($userId, $commentaire = null)
    {
        $this->update([
            'statut_validation' => 'Rejeté',
            'valide_par' => $userId,
            'date_validation' => now(),
            'commentaire_validation' => $commentaire
        ]);
    }

    public static function genererMatricule()
    {
        do {
            $matricule = 'CSAR-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('matricule', $matricule)->exists());

        return $matricule;
    }
}
