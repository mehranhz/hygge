<?php

namespace App\Services;

use App\DTO\PaginatedData;
use App\DTO\Response\BaseResponse;
use App\DTO\Response\FAQ\FAQCreateResponse;
use App\DTO\Response\FAQ\FAQResponse;
use App\Exceptions\RepositoryException;
use App\Exceptions\ServiceCallException;
use App\Repository\FAQRepositoryInterface;
use App\Services\Contracts\FAQServiceInterface;

class FAQService implements FAQServiceInterface
{
    protected FAQRepositoryInterface $FAQRepository;

    public function __construct(FAQRepositoryInterface $FAQRepository)
    {
        $this->FAQRepository = $FAQRepository;
    }

    /**
     * @param array $attributes
     * @return FAQCreateResponse
     * @throws ServiceCallException
     */
    public function create(array $attributes): FAQCreateResponse
    {
        try {
            $instance = $this->FAQRepository->create([
                "title" => $attributes["title"],
                "description" => $attributes["description"],
                "visibility" => $attributes["visibility"] ?? false
            ]);

            return new FAQCreateResponse(
                $instance->getTitle(),
                $instance->getDescription(),
                $instance->getVisibility()
            );
        } catch (RepositoryException $exception) {
            throw new ServiceCallException("error while trying to insert new faq record");
        }
    }

    /**
     * @param array $filters
     * @return PaginatedData
     * @throws ServiceCallException
     */
    public function get(array $filters): PaginatedData
    {
        try {
            return $this->FAQRepository->get($filters);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException();
        }
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
            return $this->FAQRepository->update($id, $attributes);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException();
        }
    }

    /**
     * @param int $id
     * @return bool
     * @throws ServiceCallException
     */
    public function delete(int $id): bool
    {
        try {
            return $this->FAQRepository->delete($id);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException($exception->getMessage(), $exception->getCode());
        }
    }

    public function getByID(int $id): BaseResponse
    {
        try {
            $instance = $this->FAQRepository->getByID($id);
            if ($instance){
                return new FAQResponse(
                    $instance->getTitle(),
                    $instance->getDescription(),
                    $instance->getVisibility(),
                );
            }
            throw new ServiceCallException("unknown error while trying to get faq with id $id");
        }catch (RepositoryException $exception){
            throw new ServiceCallException($exception->getMessage());
        }
    }
}
