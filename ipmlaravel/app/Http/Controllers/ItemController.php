<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ITemRequest;

class ItemController extends Controller
{
    
    public function index(Request $request)
    {
        $limit      = $request['limit'];
        $limitPage  = $request['page'] - 1;
        $offset     = $limit * $limitPage;
        $order      = $request['order'] == 'order'? 'ASC' : 'DESC';
        $field      = $request['field'];
        $filter     = $request['filter'];

        $count = Item::count();

        $data = Item::with('item_type')->where($field, 'LIKE' , '%'.$filter.'%')->take($limit)->skip($offset)->orderBy('item_type_id', 'ASC')->orderBy($field, $order)->get();

        return response()->json(compact('count','data'),200);
    }

    public function show()
    {

        $data = Item::with('item_type')->orderBy('item_type_id','ASC')->orderBy('model','ASC')->get();

        return response()->json(compact('data'),200);

    }


   public function store(ITemRequest $request)
    {
        Item::create($request->all());
        $status = 200;
        $msg    = 'Saved';
        return response()->json(compact('status', 'msg'));
    }


    // public function check(Request $request)
    // {
    //     $field      = $request['uniqueField'];
    //     $value      = $request['uniqueValue'];
    //     $id         = $request['uniqueId'];
        
    //     $count      = Item::where('item_id','=',$id)->where($field,'=',$value)->count();

    //     if($count == 0)
    //     {
    //         $count      = Item::where($field,'=',$value)->count();
    //     }
    //     else
    //     {
    //         $count      = 0;
    //     }
        
        
    //     ($count>0) ? $status = 403 : $status = 200;

    //     return response()->json(compact('status'));   
    // }




    public function update(ITemRequest $request, $id)
    {
         $data['model']             = $request['model'];
         $data['item_type_id']      = $request['item_type_id'];
        
             
        Item::where('item_id','=',$id)->update($data);
        $status = 200;
        

         return response()->json(compact('status'));
    }
}
