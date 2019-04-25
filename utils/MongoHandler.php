<?php
/**
 * Created by PhpStorm.
 * User: dempsey
 * Date: 19-3-20
 * Time: 下午6:13
 */

namespace app\utils;

class MongoHandler extends UploadHandler
{


    protected function handle_file_upload($uploaded_file, $name, $size, $type, $error, $index = null, $content_range = null)
    {
        $file = new \stdClass();
        $file->name = $name;
        $file->size = $this->fix_integer_overflow((int)$size);
        $file->type = $type;
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
          MongoService::insertFile($uploaded_file,$name);

        }
        return $file;
    }

}
