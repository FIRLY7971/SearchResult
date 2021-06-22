<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Category.php';

class CategoryHelper
{
    public static function getCategories()
    {
        return [
            new Category([
                'title' => 'Fashion-новости',
                'folder' => '1-fashion-news',
                'slug' => 'fashion-news'
            ]),
            new Category([
                'title' => 'Обзоры',
                'folder' => '2-collection',
                'slug' => 'collection'
            ]),
            new Category([
                'title' => 'Вас заинтересует',
                'folder' => '3-interest',
                'slug' => 'interest'
            ]),
            new Category([
                'title' => 'Backstage',
                'folder' => '4-backstage',
                'slug' => 'backstage'
            ])
        ];
    }

    public static function getBySlug($slug)
    {
        foreach (self::getCategories() as $category) {
            if ($category->slug === $slug) {
                return $category;
            }
        }

        return null;
    }
}