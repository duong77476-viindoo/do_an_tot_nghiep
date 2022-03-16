<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        Paginator::useBootstrap();
        $sliders = Slider::paginate(5);
        return view('admin.slider.index')->with(compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.slider.create');
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
            'desc' => 'required|max:50',
            'link' => 'required',
            'image' => 'required',
        ]);

        $slider = new slider();
        $data = $request->all();

        $slider->name = $data['name'];
        $slider->desc = $data['desc'];
        $slider->link = $data['link'];
        $slider->an_hien = $data['an_hien'];
        $slider->created_at = now();
        $slider->updated_at = now();


        $get_image = $request->file('image');
        if($get_image){
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = Str::slug($slider->name);
            $image = time().'_'.$image_name.'.'.$get_image_extension;
            $get_image->move('public/uploads/sliders',$image);
            $slider->image = $image;
        }else{
            $slider->image = 'no-image.jpeg';
        }
//        VarDumper::dump($slider);
//        exit();
        $slider->save();
        Session::put('message','<p class="text-success">Thêm slider thành công</p>');
        return Redirect::to('add-slider');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //

        $sliders = slider::where('id', $id)->get();


//        VarDumper::dump($category_sliders_id);
//        exit();
        return view('admin.slider.view')
            ->with('sliders',$sliders);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $sliders = slider::where('id', $id)->get();

        return view('admin.slider.edit')
            ->with('sliders',$sliders);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validated = $request->validate([
            'name' => 'required|min:6|max:50',
            'desc' => 'required|max:50',
            'link' => 'required',
            'image' => 'required',
        ]);

        $slider = Slider::find($id);
        $data = $request->all();

        $slider->name = $data['name'];
        $slider->desc = $data['desc'];
        $slider->link = $data['link'];
        $slider->updated_at = now();


        #lưu ảnh
        $get_image = $request->file('image');
        if($get_image){//nếu cập nhật ảnh mới cần xóa ảnh cũ + unlink
            $anh_cu = $slider->image;
            if($anh_cu!='no-image.jpeg')
                unlink('public/uploads/sliders/'.$anh_cu);
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = Str::slug($slider->name);
            $image = time().'_'.$image_name.'.'.$get_image_extension;

            $slider->image = $image;//$image tương ứng vói ảnh mới
            $get_image->move('public/uploads/sliders',$image);
        }
//        VarDumper::dump($slider);
//        exit();
        $slider->save();
        Session::put('message','<p class="text-success">Cập nhật slider thành công</p>');
        return Redirect::to('all-slider');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $slider = slider::find($id);
        $slider->delete();
        Session::put('message','<p class="text-success">Xóa thành công</p>');
        return Redirect::to('all-slider');
    }

    public function active_slider($id){
        slider::where('id', $id)
            ->update(['an_hien' => 0]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-slider');
    }

    public function unactive_slider($id){

        slider::where('id', $id)
            ->update(['an_hien' => 1]);
        Session::put('message','<p class="text-success">Update thành công</p>');
        return Redirect::to('all-slider');
    }
}
