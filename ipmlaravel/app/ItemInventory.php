<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class ItemInventory extends Model
{
    protected $table = 'itemInventory';
    
    protected $primaryKey = 'item_inventory_id';

    protected $fillable = [
        'item_id',
        'date_inventory',
        'details',
        'item_status_id',
        'project_id',
        'qty',
        'user_id'
    ];

    public function item ()
    {
        return $this->belongsTo('App\Item','item_id');
    }

    public function item_status ()
    {
        return $this->belongsTo('App\ItemStatus','item_status_id');
    }
}
