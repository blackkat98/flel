<?php

namespace App\Helper;

use Illuminate\Support\Facades\Storage;

class MediaDeletion
{
    /**
     * Delete Storage content from Storage using Storage Facade.
     *
     * @param  mixed  $source
     * @return void
     */
    public static function delete($source)
    {
        if (is_array($source)) {
            foreach ($source as $path) {
                $folder = config('customize.storage_dir');
                $simple_path = str_replace($folder, '', $path);

                Storage::disk('public')->delete($simple_path);
            }
        } else {
            $folder = config('customize.storage_dir');
            $simple_path = str_replace($folder, '', $source);

            Storage::disk('public')->delete($simple_path);
        }
    }
}