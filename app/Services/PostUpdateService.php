<?php

namespace App\Services;

use App\Exceptions\ErrorCode;
use App\Exceptions\ServiceCallException;
use App\Repository\PostRepositoryInterface;
use App\Services\Contracts\PostUpdateInterface;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\RecordsNotFoundException;

class PostUpdateService implements PostUpdateInterface
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * @param int $id
     * @param array $attributes
     * @return bool
     * @throws ServiceCallException
     */
    public function update(int $id, array $attributes): bool
    {
        try {
            if ($this->postRepository->update($id, $attributes)) {
                return true;
            }
            throw new ServiceCallException('updating post failed.', ErrorCode::Unknown->value);
        } catch (AuthorizationException $exception) {
            throw new ServiceCallException('action is unauthorized', code: 403, httpStatusCode: 403);
        } catch (RecordsNotFoundException $exception) {
            throw new ServiceCallException($exception->getMessage(), ErrorCode::ResourceNotFound->value, httpStatusCode: 404);
        } catch (\Exception $exception) {
            $message = $exception->getMessage();
            throw new ServiceCallException("updating post failed: $message.", ErrorCode::Unknown->value);
        }
    }
}
