<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    protected $table = 'itemType';
    protected $primaryKey = 'item_type_id';


    protected $fillable = [
        'item_type'
    ];
}
