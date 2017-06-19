<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemStatus extends Model
{
    protected $table = 'itemStatus';
    protected $primaryKey = 'item_status_id';

    protected $fillable = [
        'item_status'
    ];
}
