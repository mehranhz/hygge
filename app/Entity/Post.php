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
     * @param int $readTime
     */
    public function __construct(
        private int         $id,
        private string      $title,
        private string|null      $body,
        private string|null $thumbnail = null,
        private string|null $metaDescription = null,
        private string|null $metaTitle = null,
        private User        $author,
        private int $readTime = 0,
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
     * @return string|null
     */
    public function getThumbnail(): string | null
    {
        return $this->thumbnail;
    }

    /**
     * @return string|null
     */
    public function getMetaDescription(): string | null
    {
        return $this->metaDescription;
    }

    /**
     * @return string|null
     */
    public function getMetaTitle(): string | null
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

    /**
     * @return int
     */
    public function getReadTime(): int
    {
        return $this->readTime;
    }


    /**
     * @return string
     */
    public function getThumbnailFullPath(): string
    {
        return env("APP_URL")."/".$this->getThumbnail();
    }
}
