<?php

use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;



if (! function_exists('file_to_url')) {
    function file_to_url(Array $data)
    {

        if(isset($data['thumbnail'])){
         $data['thumbnail'] = make_base64_to_file($data['title'], $data['thumbnail'], 'product');
        }

          return $data;
    }
}


if (! function_exists('make_base64_to_file')) {

    function make_base64_to_file($title,$image,$path)
    {
        if (strlen($image) < 255) {
            return $image;
          }


          $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf

          $replace = substr($image, 0, strpos($image, ',') + 1);


          $imageConvert = str_replace($replace, '', $image);

          $imageConvert = str_replace(' ', '+', $imageConvert);

          $fileNameForSaving = time().'-'.Str::slug($title).'.'.$extension;

          $destinationPath = public_path('/images/'.$path . '/');

          $img = Image::make(base64_decode($imageConvert));

          File::exists($destinationPath) or File::makeDirectory($destinationPath, 0777, true, true);

          $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
          })->save($destinationPath.'/'.$fileNameForSaving);


          $slug = '/images/'.$path.'/'.$fileNameForSaving;



          return $slug;

    }
}


if (! function_exists('make_file')) {

    function make_file($image, $path)
    {

        $type = $image->extension();
        $FileName = explode('.',$image->getClientOriginalName())[0];
        $fileNameForSaving = time().'-'.Str::slug($FileName).'.'.$type;
        $destinationPath = public_path('/images/'.$path . '/');

        $img = Image::make($image->getRealPath());
        File::exists($destinationPath) or File::makeDirectory($destinationPath, 0777, true, true);
        $img->resize(800, 800, function ($constraint) {
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$fileNameForSaving);

        $image->move($destinationPath, $fileNameForSaving);

        $slug = '/images/'.$path.'/'.$fileNameForSaving;

        return $slug;
    }
}


if (! function_exists('array_difference')) {

    function array_difference(array $array1, array $array2, array $keysToCompare = null)
    {
        $serialize = function (&$item, $idx, $keysToCompare) {
            if (is_array($item) && $keysToCompare) {
                $a = array();
                foreach ($keysToCompare as $k) {
                    if (array_key_exists($k, $item)) {
                        $a[$k] = $item[$k];
                    }
                }
                $item = $a;
            }
            $item = serialize($item);
        };

        $deserialize = function (&$item) {
            $item = unserialize($item);
        };

        array_walk($array1, $serialize, $keysToCompare);
        array_walk($array2, $serialize, $keysToCompare);

        // Items that are in the original array but not the new one
        $deletions = array_diff($array1, $array2);
        $insertions = array_diff($array2, $array1);

        array_walk($insertions, $deserialize);
        array_walk($deletions, $deserialize);

        return array('insertions' => $insertions, 'deletions' => $deletions);
    }
}




if (! function_exists('delete_gallery_item')){
    function delete_gallery_item ($data){
        foreach ($data['insertions'] as $key => $value) {
            $image = Gallery::where('id', $value['id'])->first();
            $image->delete();
        }

        return true;
    }
}


if (! function_exists('public_path')) {
    /**
     * Get the path to the public folder.
     *
     * @param  string  $path
     * @return string
     */
    function public_path($path = '')
    {
        return rtrim(app()->basePath('public/' . $path), '/');
    }
}



if (! function_exists('create_gallery')) {

    function create_gallery($data,$slug)
    {


        $createdData = Gallery::firstOrCreate([
            'user_id'       => $data['user_id'],
            'post_id'       => $data['post_id'],
            'file_name'     => $data['title'],
            'alt_text'      => $data['title'],
            'slug'          => $slug,
            'type'          => 'product',
        ]);

        return $createdData;

    }
}


