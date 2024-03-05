<?php

namespace App\Services;

use App\DTO\PaginatedData;
use App\DTO\Response\FAQ\FAQCreateResponse;
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

    public function update(int $id, array $attributes): bool
    {
        try {
            return $this->FAQRepository->update($id, $attributes);
        } catch (RepositoryException $exception) {
            throw new ServiceCallException();
        }
    }
}
