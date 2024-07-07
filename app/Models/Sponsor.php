<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    use HasFactory;
    // protected $guarded=['id'];
    protected $fillable =['title','description','url','logo','sponsored'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function sortOnId()
    {
        return self::orderBy('id')->get();
    }

    public function sortOnTitle()
    {
        return self::orderBy('title')->get();
    }

    public function sortOnLogo()
    {
        return self::orderBy('logo')->get();
    }

    public function sortOnRank()
    {
        return self::orderBy('rank')->get();
    }

    public function sortOnSponsored()
    {
        return self::orderBy('sponsored')->get();
    }

    public function sortOnUrl()
    {
        return self::orderBy('url')->get();
    }

    public function sortOnCreator()
    {
        return self::orderBy('user_id')->get();
    }
}
