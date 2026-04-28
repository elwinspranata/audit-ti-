<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';
    protected $fillable = ['nama', 'cobit_item_id'];

    public function cobitItem()
    {
        return $this->belongsTo(CobitItem::class);
    }
    public function levels()
{
    return $this->hasMany(Level::class);
}

}
