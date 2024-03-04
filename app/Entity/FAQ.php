<?php

namespace App\Entity;

class FAQ
{
    public function __construct(
        protected string $title,
        protected string $description,
        protected bool $visibility = false
    )
    {
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getVisibility()
    {
        return $this->visibility;
    }

    /**
     * @param null $visibility
     */
    public function setVisibility($visibility): void
    {
        $this->visibility = $visibility;
    }
}
