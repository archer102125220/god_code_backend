<?php

namespace App\Http\Controllers\Api\File;

use App\Http\Controllers\Controller;
use App\Model\Eloquent\File;
use Illuminate\Http\Request;
use Response;
use Storage;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $files = File::fromRequest($request);
        $paginator = $files->paginate(10)->appends($request->input());
        return Response::json($paginator, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Eloquent\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        return Response::json($file, 200);
    }

    public function download(File $file)
    {
        return Storage::download($file->realpath);
    }
}
