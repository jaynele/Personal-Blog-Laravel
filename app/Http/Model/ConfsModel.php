<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class ConfsModel extends Model
{
    protected $table = "confs";
    protected $primaryKey = "conf_id";
    public $timestamps = false;
    protected $guarded = [];
}
