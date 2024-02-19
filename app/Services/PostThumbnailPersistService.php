<?php

namespace App\Services;

use App\DTO\Response\BaseResponse;
use App\DTO\Response\Blog\ThumbnailUploadResponse;
use App\Exceptions\ServiceCallException;
use App\Services\Contracts\FilePersistInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class PostThumbnailPersistService implements FilePersistInterface
{

    /**
     * @param UploadedFile $file
     * @return BaseResponse
     * @throws ServiceCallException
     */
    public function save(UploadedFile $file): BaseResponse
    {
        try {
            $fullPath = Storage::disk('local')
                ->put("/public/thumbnails", $file);
            return new ThumbnailUploadResponse(
                str_replace('public', 'storage', $fullPath)
            );

        } catch (\Exception $exception) {
            throw new ServiceCallException("uploading file failed");
        }
    }
}
