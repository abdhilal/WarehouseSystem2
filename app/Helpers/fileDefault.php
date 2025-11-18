<?php

use App\Models\File;



if (!function_exists('setDefaultFile')) {

     function getDefaultFileId()
    {
        $file=File::where('is_default',1)->first();
        return $file->id;
    }
}

