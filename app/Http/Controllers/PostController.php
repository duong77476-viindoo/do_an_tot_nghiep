<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //
        Paginator::useBootstrap();
        $posts = Post::paginate(5);

        return view('admin.post.index')->with('posts',$posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $post_types = PostType::all();
        return view('admin.post.create')
            ->with('post_types',$post_types);
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
            'title' => 'required|min:6',
            'desc' => 'required|max:50',
            'content' => 'required',
            'post_type_id'=>'required',
            'meta_keywords'=>'required',
        ]);

        $post = new Post();
        $data = $request->all();

        $post->title = $data['title'];
        $post->desc = $data['desc'];
        $post->content = $data['content'];
        $post->status = $data['status'];
        $post->meta_keywords = $data['meta_keywords'];
        $post->post_type_id = $data['post_type_id'];
        //$post->post_slug = API_V1::createCode( $data['post_name']);
        $post->nguoi_tao = Auth::user()->name;
        $post->nguoi_sua = Auth::user()->name;
        $post->created_at = now();
        $post->updated_at = now();



        $get_image = $request->file('image');
        if($get_image){
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = Str::slug($post->title);
            $image = time().'_'.$image_name.'.'.$get_image_extension;
            $get_image->move('public/uploads/posts',$image);
            $post->image = $image;
        }else{
            $post->image = 'no-image.jpeg';
        }
//        VarDumper::dump($post);
//        exit();
        $post->save();

        Session::put('message','<p class="text-success">Thêm bài viết thành công</p>');
        return Redirect::to('add-post');
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
        $post_types = PostType::all();
        $posts = post::where('id', $id)->get();

//        VarDumper::dump($category_posts_id);
//        exit();
        return view('admin.post.view')
            ->with('posts',$posts)
            ->with('post_types',$post_types);
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

        $posts = Post::where('id', $id)->get();
        $post_types = PostType::all();

//        VarDumper::dump($category_posts_id);
//        exit();
        return view('admin.post.edit')
            ->with('posts',$posts)
            ->with('post_types',$post_types);
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
        //
        $validated = $request->validate([
            'title' => 'required|min:6',
            'desc' => 'required|max:50',
            'content' => 'required',
            'post_type_id'=>'required',
            'meta_keywords'=>'required',
        ]);

        $post = Post::find($id);
        $data = $request->all();

        $post->title = $data['title'];
        $post->desc = $data['desc'];
        $post->content = $data['content'];
        $post->meta_keywords = $data['meta_keywords'];
        $post->post_type_id = $data['post_type_id'];
        //$post->post_slug = API_V1::createCode( $data['post_name']);
        $post->nguoi_sua = Auth::user()->name;
        $post->updated_at = now();

        #lưu ảnh
        $get_image = $request->file('image');
        if($get_image){//nếu cập nhật ảnh mới cần xóa ảnh cũ + unlink
            $anh_cu = $post->image;
            if($anh_cu!='no-image.jpeg')
                unlink('public/uploads/posts/'.$anh_cu);
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = Str::slug($post->title);
            $image = time().'_'.$image_name.'.'.$get_image_extension;

            $post->image = $image;//$image tương ứng vói ảnh mới
            $get_image->move('public/uploads/posts',$image);
        }
//        VarDumper::dump($post);
//        exit();
        $post->save();

        Session::put('message','<p class="text-success">Sửa bài viết thành công</p>');
        return Redirect::to('all-post');
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
        $post = Post::find($id);
        $post->delete();
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-post');
    }

    public function active_post($id){
        post::where('id', $id)
            ->update(['status' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-post');
    }

    public function unactive_post($id){

        post::where('id', $id)
            ->update(['status' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-post');
    }
}
