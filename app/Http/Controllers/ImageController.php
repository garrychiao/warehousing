<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Image;
use DB;
use File;

class ImageController extends Controller
{
    public function addImage(Request $request, $resource, $item ,$item_id)
    {
      if (!file_exists('img/'.$resource.'/'.$item)) {
        mkdir('img/'.$resource.'/'.$item, 0777, true);
      }
      $img = Image::make($_FILES['fileToUpload']['tmp_name']);
      $destinationPath = 'img/'.$resource.'/'.$item.'/'.$_FILES['fileToUpload']['name'];
      // save image
      $img->save($destinationPath);
      DB::table('image_url')->insert(
        [
          'img_resource' => $item,
          'parent' =>$resource,
          'img_url' => $destinationPath
        ]
      );
      if(is_numeric($item_id)){
        return redirect($resource.'/'.$item_id)->with('message', 'Image Uploaded!');
      }else{
        return redirect($resource)->with('message', 'Image Uploaded!');
      }
    }

    //show images for futher control
    public function viewImage($id,$item_id)
    {
      $img = DB::table('image_url')->where('id','=',$id)->get();
      if(is_numeric($item_id)){
        return view('/image/view')->with('img',$img)->with('item_id',$item_id);
      }else{
        return view('/image/view')->with('img',$img)->with('item_id',null);
      }
    }

    public function deleteImage($id,$item_id)
    {
      $file = DB::table('image_url')->where('id', '=', $id)->first();
      $parent = $file->parent;
      File::delete($file->img_url);
      DB::table('image_url')->where('id', '=', $id)->delete();
      if(is_numeric($item_id)){
        return redirect($parent.'/'.$item_id)->with('message', 'Image Deleted!');
      }else{
        return redirect($parent)->with('message', 'Image Deleted!');
      }
    }

}
