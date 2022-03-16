<?php

namespace App\Http\Controllers;

use App\Models\post_type;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PostTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Paginator::useBootstrap();

        $post_types = PostType::paginate(5);
        return view('admin.post_type.all_post_type')->with('post_types',$post_types);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('admin.post_type.add_post_type');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'name' => 'required|min:6|max:50',
            'status' => 'required',
            'meta_keywords' => 'required',
        ]);
        $post_type = new PostType();
        $data = $request->all();
        $post_type->name = $data['name'];
        $post_type->desc = $data['desc'];
        $post_type->status = $data['status'];
        $post_type->meta_keywords = $data['meta_keywords'];
        $post_type->created_at = now();
        $post_type->updated_at = now();
        $post_type->save();
        Session::put('message','<p class="text-success">Thêm danh mục bài viết thành công</p>');
        return Redirect::to('add-post-type');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post_type = PostType::where('id', $id)->get();;
        return view('admin.post_type.view_post_type')->with('post_type',$post_type);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post_type = PostType::where('id', $id)->get();
        return view('admin.post_type.edit_post_type')->with('post_type',$post_type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|min:6|max:50',
            'status' => 'required',
            'meta_keywords' => 'required',
        ]);
        $data = $request->all();
        PostType::where('id', $id)
            ->update
            ([
                'name'=> $data['name'],
                'desc'=> $data['desc'],
                'meta_keywords' => $data['meta_keywords'],
                'updated_at' => now()
            ]);
        Session::put('message','<p class="text-success" ">Sửa loại danh mục bài viết thành công</p>');
        return Redirect::to('all-post-type');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post_type = PostType::destroy($id);
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-post-type');
    }

    public function active_post_type($id){
        PostType::where('id', $id)
            ->update(['status' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-post-type');
    }

    public function unactive_post_type($id){

        PostType::where('id', $id)
            ->update(['status' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-post-type');
    }
}
