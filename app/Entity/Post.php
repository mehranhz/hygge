<?php

namespace App\Entity;

class Post
{
    public function __construct(
        private string $title,
        private string $body,
        private string $thumbnail,
        private string $metaDescription,
        private string $metaTitle,
        private User   $author
    )
    {
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
