<?php

class Post
{
    /** @var string $title */
    public $title;

    /** @var string $description */
    public $description;

    /** @var Category $category */
    public $category;

    /** @var string $image */
    public $image;

    /** @var string $slug */
    public $slug;

    /** @var string $content */
    public $content;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}