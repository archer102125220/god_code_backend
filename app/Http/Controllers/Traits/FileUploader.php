<?php

namespace App\Http\Controllers\Traits;

use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \App\Http\Controllers\Traits\FileReferable;
use \App\Model\Eloquent\File;
use \Illuminate\Http\Request;
use \Illuminate\Support\Facades\Response;

trait FileUploader
{
    use FileReferable;

    protected $allowExtensions = [
        'image' => ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
        'document' => ['txt', 'pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'],
    ];

    protected $allowMimeTypes = [
        'image' => ['image/jpeg', 'image/gif', 'image/png', 'image/bmp'],
        'document' => ['text/plain', 'application/pdf', 'application/msword', 'application/vnd.ms-excel', 'application/vnd.ms-powerpoint'],
    ];

    /**
     * @throws InvalidUploadException
     */
    protected function validUploadedRequest(Request $request, String $field)
    {
        if ($request->hasFile($field)) {
            $uploadedFile = $request->file($field);
            if (!$uploadedFile->isValid()) {
                throw new InvalidUploadException($uploadedFile->getErrorMessage());
            }
            return $uploadedFile;
        }
        return false;
    }

    /**
     * @throws InvalidExtensionException
     * @throws InvalidMimeTypeException
     */
    protected function validUploadedFile(UploadedFile $uploadedFile, $fileType = null)
    {
        if (!in_array($uploadedFile->getClientOriginalExtension(), $this->allowFileExtension[$fileType]) && !is_null($fileType)) {
            throw new InvalidExtensionException('Files with extension (' . $uploadedFile->getClientOriginalExtension() . ') are not allowed');
        }
        if (!in_array($uploadedFile->getMimeType(), $this->allowFileMimeTypes[$fileType]) && !is_null($fileType)) {
            throw new InvalidMimeTypeException('Files with mime type (' . $uploadedFile->getMimeType() . ' are not allowed');
        }
    }

    /**
     *
     * @throws InvalidUploadException
     * @throws InvalidExtensionException
     * @throws InvalidMimeTypeException
     * @return Response
     */
    protected function putFileFromRequest(Request $request, String $field, $unit = null)
    {
        $uploadedFile = $this->validUploadedRequest($request, $field);
        if ($uploadedFile) {
            $file = $this->putFile($uploadedFile, $unit);
            return Response::json($file, 200);
        }
        return Response::json(null, 400);
    }

    /**
     *
     * @throws InvalidUploadException
     * @throws InvalidExtensionException
     * @throws InvalidMimeTypeException
     * @return File
     */
    protected function putFile(UploadedFile $uploadedFile, $unit = null)
    {
        $realPath = Storage::putFile(is_null($unit) ? 'temp' : $unit, $uploadedFile);
        return File::create($this->prepareUploadData($uploadedFile, $unit, $realPath));
    }

    protected function prepareUploadData(UploadedFile $uploadedFile, $unit = null, $realPath = '')
    {
        return [
            'unit' => $unit,
            'name' => $uploadedFile->getClientOriginalName(),
            'realpath' => $realPath,
            'extension' => $uploadedFile->getClientOriginalExtension(),
            'mimetype' => $uploadedFile->getMimeType(),
            'size' => $uploadedFile->getSize(),
        ];
    }

}
