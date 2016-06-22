<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Artical extends Model
{
    protected $table = "artical";
    protected $primaryKey = "art_id";
    public $timestamps = false;
    protected $guarded = [];
}
