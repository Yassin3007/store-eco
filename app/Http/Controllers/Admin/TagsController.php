<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagsRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class TagsController extends Controller
{
    public function index(){
        $tags = Tag::orderBy('id','DESC')->paginate(PAGINATION_COUNT);
        return view('admin.tags.index',compact('tags'));
    }

    public function create(){
        return view('admin.tags.create');
    }

    public function store(TagsRequest $request){


        try {
            DB::beginTransaction();

            $tag = Tag::create($request->only('slug'));

            $tag->name = $request->name ;
            $tag->save();
            DB::commit();

            return redirect()->route('admin.tags')->with(['success'=>'تم الاضافة بنجاح ']);

        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error'=>'حدث خطا ما ']);

        }
    }

    public function edit($id){
        $tag = Tag::find($id);
        if(! $tag){
            return redirect()->route('admin.tags')->with(['error'=>'هذا العنصر غير موجود ']);
        }
        return view('admin.tags.edit',compact('tag'));
    }

    public function update($id , TagsRequest $request){


        try {

            $tag = Tag::find($id);
            DB::beginTransaction();

            $tag->update($request->except('_token','id'));
            $tag->name = $request->name ;
            $tag->save();
            DB::commit();
            return redirect()->route('admin.tags')->with(['success'=>'تم التعديل بنجاح ']);


        }catch (\Exception $ex){
            DB::rollBack();
            return redirect()->route('admin.tags')->with(['error'=>'حدث خطا ما ']);;

        }


    }

    public function destroy($id){
        $tag =Tag::find($id);

        if(! $tag){
            return redirect()->route('admin.tags')->with(['error'=>'هذا العنصر غير موجود ']);
        }

        $tag->delete();

        return redirect()->route('admin.tags')->with(['success'=>'تم الحذف بنجاح  ']);



    }
}
