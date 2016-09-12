<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Inventory;
use Image;
use DB;
use File;

class ImageController extends Controller
{
    public function myImage(){
      $inventory = Inventory::select('id','item_id','item_name','chi_item_name','graph_id')->paginate(10);
      $img = DB::table('image_url')->get();
      return view('/image/index')->with('inventory',$inventory)->with('img',$img);
    }

    public function addInvImage(Request $request){
      if (!file_exists('img/inventory/'.$request->inv_id)) {
        mkdir('img/inventory/'.$request->inv_id, 0777, true);
      }
      $img = Image::make($_FILES['fileToUpload']['tmp_name']);
      $destinationPath = 'img/inventory/'.$request->inv_id.'/'.$_FILES['fileToUpload']['name'];
      // save image
      $img->save($destinationPath);
      DB::table('image_url')->insert(
        [
          'inv_id' => $request->inv_id,
          'img_url' => $destinationPath
        ]
      );

      return redirect('/myImage')->with('message', 'Image Uploaded!');
    }

    public function addComImage(Request $request){
      if (!file_exists('img/mycompany')) {
        mkdir('img/mycompany', 0777, true);
      }else{
        File::deleteDirectory('img/mycompany', true);
      }
      $img = Image::make($_FILES['fileToUpload']['tmp_name']);
      $destinationPath = 'img/mycompany/'.$_FILES['fileToUpload']['name'];
      // save image
      $img->save($destinationPath);
      DB::table('my_companies')->update(
        [
          'img_url' => $destinationPath
        ]
      );

      return redirect('/mycompany')->with('message', 'Image Uploaded!');
    }

    public function deleteInvImage($id)
    {
      $file = DB::table('image_url')->where('id', '=', $id)->first();
      File::delete($file->img_url);
      DB::table('image_url')->where('id', '=', $id)->delete();

      return redirect('/myImage')->with('message', 'Image Deleted!');
    }
    /*public function addImage(Request $request, $resource, $item ,$item_id)
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
    */
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



}
