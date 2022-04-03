<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
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
        $videos = Video::all();
        return view('admin.video.index')->with(compact('videos'));
    }


    public function select_video(Request $request){
        $videos =  Video::orderBy('id','DESC')->get();
        $video_count = $videos->count();
        $output = '
          <form>
            '.csrf_field().'
            <table id="myTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tiêu đề</th>
                                        <th>Mô tả</th>
                                        <th>Link</th>
                                        <th>Hình ảnh</th>
                                        <th>Demo video</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
        ';
        if($video_count>0){
            $i=0;
            foreach ($videos as $key=>$video){
                $i++;
                $output.='

                         <tr>
                            <td>'.$i.'</td>
                            <td contenteditable="true" data-video_id="'.$video->id.'" id="title_'.$video->id.'" data-video_col="title" class="video_edit">'.$video->title.'</td>
                            <td contenteditable="true" data-video_id="'.$video->id.'" id="desc_'.$video->id.'" data-video_col="desc" class="video_edit">'.$video->desc.'</td>
                            <td contenteditable="true" data-video_id="'.$video->id.'" id="link_'.$video->id.'" data-video_col="link" class="video_edit">https://youtu.be/'.$video->link.'
                            </td>
                            <td>
                                <img src="'.url('public/uploads/videos/'.$video->image).'" alt="" class="img-thumbnail" width="300px" height="300px">
                                <input type="file" class="video_image" data-video_id="'.$video->id.'" id="file_'.$video->id.'" name="file" accept="image/*">
                            <td>
                            <iframe width="400"
                                height="315"
                                src="https://www.youtube.com/embed/'.$video->link.'"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                                </iframe>
                            </td>
                            <td>
                                <button type="button" data-toggle="modal" data-target="#video_modal" class="btn btn-primary">Xem video
                                </button>
                                <button data-video_id="'.$video->id.'" class="btn btn-danger delete-video">Xóa video</button>
                            </td>

                         </tr>
                    </form>
                ';
            }
        }else{
            $output.='
             <tr>
                <td colspan="6">Chưa có video</td>
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

    public function insert_video(Request $request){
        $validator = Validator::make($request->all(), [
            'video_title'=>'required',
            'video_desc'=>'required',
            'video_link'=>'required',
        ]);
        if ($validator->passes()) {
            $data = $request->all();
            $video = new Video();
            $link_video = substr($data['video_link'],17);
            $video->title = $data['video_title'];
            $video->desc = $data['video_desc'];
            $video->link = $link_video;
            $get_image = $data['video_image'];
            if($get_image){
                $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
                $get_image_name = $get_image->getClientOriginalName();//lấy tên ảnh bằng hàm getClient...
                //$image_name = current(explode('.',$get_image_extension));
                $image_name = current(explode('.',$get_image_name));
                $new_image = time().'_'.$image_name.'.'.$get_image_extension;
                $get_image->move('public/uploads/videos',$new_image);
                $video->image = $new_image;
            }
            $video->save();
            return response()->json(['success'=>'<span class="text-success">Thêm video thành công</span>']);
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function update_video(Request $request){
        $data = $request->all();
        $video_id = $data['video_id'];
        $video_col = $data['video_col'];
        $video_data = $data['video_data'];
        $video = Video::find($video_id);
        if($video){
            if($video_col=='title'){
                $video->title = $video_data;
            }elseif ($video_col=='desc'){
                $video->desc = $video_data;
            }else{
                $link_video = substr($video_data,17);
                $video->link = $link_video;
            }
            $video->save();
            return response()->json(['success'=>'<span class="text-success">Cập nhật video thành công</span>']);
        }else
            return response()->json(['error'=>'Lỗi khi cập nhật video']);
    }

    public function delete_video(Request $request){
        $video = Video::find($request->video_id);
        if($video){
            unlink('public/uploads/videos/'.$video->image);
            $video->delete();
            return response()->json(['success'=>'<span class="text-success">Xóa video thành công</span>']);
        }
        else{
            return response()->json(['error'=>'Lỗi khi xóa video']);
        }
    }

    public function update_video_image(Request $request){
        $get_image = $request->file('video_image');
        $video_id = $request->video_id;
        if($get_image){
            $get_image_extension = $get_image->getClientOriginalExtension();//lấy đuôi ảnh bằng hàm getClient...
            $get_image_name = $get_image->getClientOriginalName();//lấy tên ảnh bằng hàm getClient...
            //$image_name = current(explode('.',$get_image_extension));
            $image_name = current(explode('.',$get_image_name));
            $new_image = time().'_'.$image_name.'.'.$get_image_extension;
            $get_image->move('public/uploads/videos',$new_image);
            $video = Video::find($video_id);
            unlink('public/uploads/videos/'.$video->image);
            $video->image = $new_image;
            $video->save();
            return response()->json(['success'=>'<span class="text-success">Cập nhật hình ảnh video thành công</span>']);
        }else{
            return response()->json(['error'=>'Lỗi khi cập nhật hình ảnh video']);
        }
    }
}
