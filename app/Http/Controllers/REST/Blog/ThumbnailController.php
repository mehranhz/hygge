<?php

namespace App\Http\Controllers\REST\Blog;

use App\Exceptions\ServiceCallException;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Controller;
use App\Http\Requests\REST\PostThumbnailUploadRequest;
use App\Services\Contracts\FilePersistInterface;
use App\Services\PostThumbnailPersistService;
use Illuminate\Http\Request;

class ThumbnailController extends APIController
{
    private FilePersistInterface $filePersistService;

    public function __construct()
    {
        parent::__construct();
        $this->filePersistService = new PostThumbnailPersistService();
    }

    public function save(PostThumbnailUploadRequest $request)
    {
        try {
            return $this->respond(
                data: $this->filePersistService->save($request->file("thumbnail"))->toArray()
            );
        } catch (ServiceCallException $exception) {
            return $this->respondFromServiceCallException($exception);
        }
    }
}
