<?php

namespace App\Http\Controllers;

use App\ItemType;
use Illuminate\Http\Request;
use App\Http\Requests\ITemTypeRequest;

class ItemTypeController extends Controller
{
  
    public function index(Request $request)
    {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = ItemType::count();

        $data = ItemType::where($field, 'LIKE' , '%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field, $order)->get();

        return response()->json(compact('count','data'),200);
    }


    public function show ()
    {
        $data = ItemType::all();

        return response()->json(compact('data'));
    }
   
    public function store(ITemTypeRequest $request)
    {
        ItemType::create($request->all());
        $status = 200;
        $msg    = 'Saved';
        return response()->json(compact('status', 'msg'));
    }


    public function check(Request $request)
    {
        $field = $request['uniqueField'];
        $value = $request['uniqueValue'];
        $count = ItemType::where($field , '=', $value)->count();
        
        ($count>0) ? $status = 403 : $status = 200;

        return response()->json(compact('status'));   
    }




    public function update(ITemTypeRequest $request, $type)
    {
         $data['item_type']     = $request['item_type'];
         $count = ItemType::where('item_type' , '=', $data['item_type'])->count();

         if($count==0)
         {
             
             ItemType::where('item_type_id','=',$type)->update($data);
             $status = 200;
         }
         else
         {
             $status = 403;
         }

         return response()->json(compact('status'));
    }

  
}
