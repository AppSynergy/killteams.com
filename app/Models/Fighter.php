<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;

class Fighter extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'fighters';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    public function delete()
    {
        if ($this->wargearselectors()->exists()) {
            $this->wargearselectors()->delete();
        }
        if ($this->specialistselector()->exists()) {
            $this->specialistselector()->delete();
        }
        parent::delete();
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function specialism()
    {
        return $this->belongsTo('App\Models\Specialism');
    }

    public function faction()
    {
        return $this->belongsTo('App\Models\Faction');
    }

    public function miniature()
    {
        return $this->belongsTo('App\Models\Miniature');
    }

    public function killteam()
    {
        return $this->belongsTo('App\Models\Killteam');
    }

    public function wargearselectors()
    {
        return $this->hasMany('App\Models\Wargearselector');
    }

    public function specialistselector()
    {
        return $this->hasOne('App\Models\Specialistselector');
    }

    public function user()
    {
        return $this->killteam->user;
    }


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
