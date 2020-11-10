<?php

namespace App\Services;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Model;


interface FileStorage
{

     public function filesToStorage ($files);
     public function filesToSaaS ($files);
     public function filesToDB ($files,$slug);
     public function fiLesDeleteFromDB ($files);


}



class StorageFiles implements  FileStorage {


    public function filesToStorage($data) {

       if(!$data) return false;
        $files = [];
       if(is_array($data)){
        if(is_array($data['images'])){
            foreach ($data['images'] as $index => $value) {
                $slug = make_file($data['title'], $value, 'product');
                $file = $this->filesToDB($data,$slug);
            }
        }else{

                $slug = make_file($data['title'], $data['images'], 'product');
                $files[] = $this->filesToDB($data,$slug);

         }
       }

       return $files;


      }

      public function filesToSaaS($files) {

        return 'Not yet!';

      }


      public function filesToDB($data,$slug) {

          return create_gallery($data,$slug);

      }

      public function fiLesDeleteFromDB($files) {

        dd($files)
         foreach ($files as $key => $value) {
            $image = Gallery::where('id', $value['id'])->first();
            $image->delete();
        }

      }



}


