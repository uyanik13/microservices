<?php

namespace App\Services;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;


interface FileStorage
{

     public function filesToStorage ($files,$id);
     public function filesToSaaS ($files);
     public function filesToDB ($files,$slug);
     public function fiLesDeleteFromDB ($files);
     public function fiLesDeleteFromStorage ($files);


}



class StorageFiles implements FileStorage {


    public function filesToStorage($request,$id)
    {

       if(!$request->has('images')) return false;

       $request['post_id'] = $id;

       if(is_array($request['images'])){
            foreach ($request['images'] as $image) {
                $slug = make_file($request->title, $image, 'product');
                $this->filesToDB($request,$slug);
            }
        }else{
                $slug = make_file($request->images, 'product');
                $this->filesToDB($request,$slug);
         }

       return true;


      }

      public function filesToSaaS($files)
      {

        return 'Not yet!';

      }


      public function filesToDB($data,$slug)
       {

          return create_gallery($data,$slug);

      }

      public function fiLesDeleteFromDB($files)
       {

            foreach ($files as $key => $file) {
                $image = Gallery::where('id', $file->id)->first();
                $image->delete();
            }

        }


      public function fiLesDeleteFromStorage($files)

       {
            foreach ($files as $key => $file) {
                if(file_exists(public_path($file->slug))){
                    unlink(public_path($file->slug));
                }else{
                    return false;
                }
            }

        }





}


