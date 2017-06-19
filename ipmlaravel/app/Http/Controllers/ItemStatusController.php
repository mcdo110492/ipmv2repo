<?php

namespace App\Http\Controllers;

use App\ItemStatus;
use Illuminate\Http\Request;
use App\Http\Requests\ITemStatusRequest;

class ItemStatusController extends Controller
{
  
    public function index(Request $request)
    {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = ItemStatus::count();

        $data = ItemStatus::where($field, 'LIKE' , '%'.$filter.'%')->take($limit)->skip($offset)->orderBy($field, $order)->get();

        return response()->json(compact('count','data'),200);
    }

    public function show()
    {
        $data = ItemStatus::all();

        return response()->json(compact('data'),200);
    }

   
    public function store(ITemStatusRequest $request)
    {
        ItemStatus::create($request->all());
        $status = 200;
        $msg    = 'Saved';
        return response()->json(compact('status', 'msg'));
    }


    public function check(Request $request)
    {
        $field = $request['uniqueField'];
        $value = $request['uniqueValue'];
        $count = ItemStatus::where($field , '=', $value)->count();
        
        ($count>0) ? $status = 403 : $status = 200;

        return response()->json(compact('status'));   
    }




    public function update(ITemStatusRequest $request, $id)
    {
         $data['item_status']     = $request['item_status'];
         $count = ItemStatus::where('item_status' , '=', $data['item_status'])->count();

         if($count==0)
         {
             
             ItemStatus::where('item_status_id','=',$id)->update($data);
             $status = 200;
         }
         else
         {
             $status = 403;
         }

         return response()->json(compact('status'));
    }

  
}
