<?php

class Category
{
    /** @var string $title */
    public $title = '';

    /** @var string $folder */
    public $folder = '';

    /** @var string $slug */
    public $slug = '';

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
}