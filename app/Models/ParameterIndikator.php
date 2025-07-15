<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterIndikator extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'target', 'satuan', 'bobot'];
    protected $table = 'parameter_indikators';
}
