<?php

namespace App\Http\Controllers;

use App\ItemInventory;
use Illuminate\Http\Request;
use App\Http\Requests\ItemInventoryRequest;
use JWTAuth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ItemInventoryController extends Controller
{
    protected $project_id;

    protected $user_id;

    protected $token;




    public function index(Request $request)
    {
        $token          = $token = JWTAuth::parseToken()->authenticate();

        $project_id     = $token->role == 1 ? $request['project_id'] : $token->project_id;


        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = ItemInventory::where('project_id','=',$project_id)->count();

        
        $data = DB::table('itemInventory as iv')
                ->leftJoin('items as i','i.item_id','=','iv.item_id')
                ->leftJoin('itemType as it','it.item_type_id','=','i.item_type_id')
                ->leftJoin('itemStatus as is','is.item_status_id','=','iv.item_status_id')
                ->where('date_inventory', 'LIKE' , '%'.$filter.'%')
                ->orWhere('i.model', 'LIKE' , '%'.$filter.'%')
                ->take($limit)
                ->skip($offset)
                ->orderBy('date_inventory', 'DESC')
                ->orderBy('i.model', $order)
                ->get();

        return response()->json(compact('count','data'),200);
    }



    public function store(ItemInventoryRequest $request)
    {
        $token          = $token = JWTAuth::parseToken()->authenticate();

        $project_id     = $token->role == 1 ? $request['project_id'] : $token->project_id;

        $user_id        = $token->user_id;

        $data = [
            'item_id'           =>  $request['item_id'],
            'date_inventory'    =>  Carbon::parse($request['date_inventory']),
            'project_id'        =>  $project_id,
            'item_status_id'    =>  $request['item_status_id'],
            'details'           =>  $request['details'],
            'qty'               =>  $request['qty'],
            'user_id'           =>  $user_id
        ];
        
       
        ItemInventory::create($data);
        
        
        
        $status = 200;
        $msg    = 'Saved';
        return response()->json(compact('status', 'msg'));
    }


 
    public function update(ItemInventoryRequest $request, $id)
    {
        $token          = $token = JWTAuth::parseToken()->authenticate();

        $user_id        = $token->user_id;

        $data = [
            'item_id'           =>  $request['item_id'],
            'date_inventory'    =>  Carbon::parse($request['date_inventory']),
            'item_status_id'    =>  $request['item_status_id'],
            'details'           =>  $request['details'],
            'qty'               =>  $request['qty'],
            'user_id'           =>  $user_id
        ];

        ItemInventory::where('item_inventory_id','=',$id)->update($data);
        $status = 200;
        

         return response()->json(compact('status'));
    }

 
}
