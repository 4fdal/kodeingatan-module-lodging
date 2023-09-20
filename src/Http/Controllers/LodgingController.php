<?php

namespace Kodeingatan\Lodging\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LodgingController extends Controller
{
    public function assets(Request $request)
    {
        $path = urldecode($request->path ?? '');
        $path =  dirname(__DIR__, 3) . '/publishable/assets/' . $path;

        if (File::exists($path)) {
            $mime = '';
            if (\Str::endsWith($path, '.js')) {
                $mime = 'text/javascript';
            } elseif (\Str::endsWith($path, '.css')) {
                $mime = 'text/css';
            } else {
                $mime = File::mimeType($path);
            }
            $response = response(File::get($path), 200, ['Content-Type' => $mime]);
            $response->setSharedMaxAge(31536000);
            $response->setMaxAge(31536000);
            $response->setExpires(new \DateTime('+1 year'));

            return $response;
        }

        return response('', 404);
    }
}
