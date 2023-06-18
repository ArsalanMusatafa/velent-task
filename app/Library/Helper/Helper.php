<?php namespace Velent\Helper;

use Illuminate\Support\Facades\Storage;
use Throwable;

class Helper
{
    public static function uploadImage($disk, $image)
    {
        $name = time() . trim($image->getClientOriginalName());
        $getPath = $disk . "/$name";
        Storage::disk($disk)->put($name, file_get_contents($image));
        return Storage::disk($disk)->url($getPath);
    }

    public static function defaultParams($request)
    {
        return [
            'search' => $request->has('search') ? $request->get('search') : null,
            'orderBy' => $request->has('orderBy') ? $request->get('orderBy') : 'id',
            'sortBy' => $request->has('sortBy') ? $request->get('sortBy') : 'desc',
            'perPage' => $request->has('perPage') ? $request->get('perPage') : 10,
        ];
    }
}
