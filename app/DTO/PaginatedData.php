<?php

namespace App\DTO;

class PaginatedData
{
    private Pagination $pagination;
    private array $data;

    /**
     * @param $data
     * @param $pagination
     */
    public function __construct($data, $pagination)
    {
        $this->pagination = new Pagination(
            $pagination["current_page"],
            $pagination["from"],
            $pagination["last_page"],
            $pagination["per_page"],
            $pagination["to"],
            $pagination["total"],
        );
        $this->data = $data;

    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return Pagination
     */
    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    /**
     * @return array
     */
    public function getPaginationArray(): array
    {
        return [
            "current_page" => $this->pagination->currentPage,
            "from" => $this->pagination->from,
            "last_page" => $this->pagination->lastPage,
            "per_page" => $this->pagination->perPage,
            "to" => $this->pagination->to,
            "total" => $this->pagination->total,
        ];
    }
}
