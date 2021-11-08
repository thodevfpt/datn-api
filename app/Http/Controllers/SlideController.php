<?php

namespace App\Http\Controllers;

use App\Http\Requests\SlideRequest;
use App\Models\Slide;
use Illuminate\Http\Request;

class SlideController extends Controller
{
         public function index(Request $request){
        $keyword=$request->input('keyword');
        $sort=$request->input('sort');
        $sort_name=$request->input('sort_name');
        $query= new Slide;
        if($keyword){
            $query=$query->where('title','like','%'.$keyword.'%');
        }
        if($sort){
            $query=$query->orderBy('created_at',$sort);
        }
         if($sort_name){
             $query=$query->orderBy('title',$sort_name);
        }
        $slide=$query->get();
        if ($slide->all()) {
            return response()->json([
                'success' => true,
                'data' => $slide
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'chưa có sp nào trong db'
            ]);
        }

    }
    public function store(SlideRequest $request){
         $model = new Slide();
         $model->fill($request->all());
         $model->save();
         return response()->json([
         'success' => true,
         'data' => $model
         ]);
    }
    public function update(SlideRequest $request,$id){
         $slide=Slide::query()->find($id);
         if($slide){
             $slide->fill($request->all());
             $slide->save();
             return response()->json([
                     'success'=>true,
                     'data'=>$slide
                 ]);
         }
         return response()->json([
                 'success'=>false,
             ]);
    }
    public function show($id){
         $slide = Slide::query()->find($id);
         if($slide){
             return response()->json([
                'success' => true,
                'data' => $slide
            ]);
         }return response()->json([
              'success'=>false,
         ]);
    }
    //xoa mem
    public function destroy($id){
        $slide=Slide::find($id);
        $slide->delete();
        return response()->json([
                'success' => true,
                'data' => $slide
            ]);
    }
}
