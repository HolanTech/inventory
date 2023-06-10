<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;
    protected $fillable = ['nama', 'alamt', 'email', 'diskon', 'tipe_diskon', 'image', 'telepon'];

    protected $table = 'member';
    protected $primaryKey = 'id_member';
    protected $guarded = [];
    use SoftDeletes;
}
