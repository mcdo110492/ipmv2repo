<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $primaryKey = 'item_id';

    protected $fillable = [
        'model',
        'item_type_id'
    ];

    public function item_type()
    {
        return $this->belongsTo('App\ItemType','item_type_id');
    }
}
