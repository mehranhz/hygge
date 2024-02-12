<?php

namespace App\Entity;

class Post
{
    /**
     * @param int $id
     * @param string $title
     * @param string $body
     * @param string|null $thumbnail
     * @param string|null $metaDescription
     * @param string|null $metaTitle
     * @param User $author
     */
    public function __construct(
        private int         $id,
        private string      $title,
        private string      $body,
        private string|null $thumbnail = null,
        private string|null $metaDescription = null,
        private string|null $metaTitle = null,
        private User        $author
    )
    {
    }

    /**
     * @return int
     */
    public function getID(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function getThumbnail(): string
    {
        return $this->thumbnail;
    }

    /**
     * @return string
     */
    public function getMetaDescription(): string
    {
        return $this->metaDescription;
    }

    /**
     * @return string
     */
    public function getMetaTitle(): string
    {
        return $this->metaTitle;
    }

    /**
     * @return User
     */
    public function getAuthor(): User
    {
        return $this->author;
    }


}
