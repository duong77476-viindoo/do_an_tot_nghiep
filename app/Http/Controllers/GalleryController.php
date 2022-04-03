<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\ProductGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //

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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gallery $gallery)
    {
        //
    }

    public function add_gallery($product_group_id){
        $product_group = ProductGroup::find($product_group_id);
        return view('admin.gallery.create')->with('product_group',$product_group);
    }

    public function select_gallery(Request $request){
        $product_group_id = $request->product_group_id;
        $gallery =  Gallery::where('product_group_id',$product_group_id)->get();
        $gallery_count = $gallery->count();
        $output = '
          <form>
            '.csrf_field().'
            <table id="myTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên hình ảnh</th>
                                        <th>Hình ảnh</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        if($gallery_count>0){
            $i=0;
            foreach ($gallery as $key=>$gal){
                $i++;
                $output.='

                         <tr>
                            <td>'.$i.'</td>
                            <td contenteditable="true" class="edit_gallery_name" data-gallery_id="'.$gal->id.'">'.$gal->name.'</td>
                            <td>
                                <img src="'.url('public/uploads/gallery/'.$gal->image).'" alt="" class="img-thumbnail" width="100px" height="100px">
                                <input type="file" class="gallery_image" data-gallery_id="'.$gal->id.'" id="file_'.$gal->id.'" name="file" accept="image/*">

                            </td>
                            <td>
                                <button type="button" data-gallery_id="'.$gal->id.'" class="btn btn-danger delete-gallery">Xóa</button>
                            </td>
                         </tr>
                    </form>
                ';
            }
        }else{
            $output.='
             <tr>
                <td colspan="3">Sản phẩm chưa có thư viện ảnh</td>
             </tr>
            ';
        }
        $output.='
             </tbody>
             </table>
             </form>
            ';
        echo $output;
    }

    public function insert_gallery(Request $request, $product_group_id){
        $validated = $request->validate([
            'file'=>'required',
        ]);
        $get_image = $request->file('file');
        if($get_image){
            foreach ($get_image as $image){
                    $gallery = new Gallery();
                    $get_image_extension = $image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
                    $get_image_name = $image->getClientOriginalName();//lấy tên ảnh bằng hàm getClient...
                    //$image_name = current(explode('.',$get_image_extension));
                    $image_name = current(explode('.',$get_image_name));
                    $new_image = time().'_'.$image_name.'.'.$get_image_extension;
                    $image->move('public/uploads/gallery',$new_image);
                    $gallery->name = $new_image;
                    $gallery->image = $new_image;
                    $gallery->product_group_id = $product_group_id;
                    $gallery->save();
            }
        }
        Session::put('message','<p class="text-success">Thêm ảnh sản phẩm thành công</p>');
        return \redirect()->back();
    }

    public function update_gallery_name(Request $request){
        $gallery_id = $request->gallery_id;
        $gallery_name = $request->gallery_name;
        $gallery = Gallery::find($gallery_id);
        $gallery->name =$gallery_name;
        $gallery->save();
    }

    public function delete_gallery(Request $request){
        $gallery_id = $request->gallery_id;
        $gallery = Gallery::find($gallery_id);
        if($gallery){
            unlink('public/uploads/gallery/'.$gallery->image);
            $gallery->delete();
        }
    }

    public function update_gallery(Request $request){
        $get_image = $request->file('file');
        $gallery_id = $request->gallery_id;
        if($get_image){
                $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
                $get_image_name = $get_image->getClientOriginalName();//lấy tên ảnh bằng hàm getClient...
                //$image_name = current(explode('.',$get_image_extension));
                $image_name = current(explode('.',$get_image_name));
                $new_image = time().'_'.$image_name.'.'.$get_image_extension;
                $get_image->move('public/uploads/gallery',$new_image);
                $gallery = Gallery::find($gallery_id);
                unlink('public/uploads/gallery/'.$gallery->image);
                $gallery->image = $new_image;
                $gallery->save();
        }
    }
}
