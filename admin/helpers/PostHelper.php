<?php

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Post.php';
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'constants.php';

class PostHelper
{
    public static function validatePost($data)
    {
        $errors = [];
        $data = array_map(function ($value) {
            if (is_string($value)) {
                $value = trim($value);
            }

            return $value;
        }, $data);

        if (!@$data['title']) {
            $errors['title'] = 'Введите название';
        }

        if (!@$data['description']) {
            $errors['description'] = 'Введите описание';
        }

        if (!@$data['category']) {
            $errors['category'] = 'Выберите категорию';
        }

        if (!@$data['slug']) {
            $errors['slug'] = 'Укажите slug';
        }

        if (!@$data['content']) {
            $errors['content'] = 'Заполните контент';
        }

        if (@$data['image']['size'] > 0) {
            if ($data['image']['size'] / 1024 > 20480) {
                $errors['image'] = 'Максимальный размер файла 20мб';
            } else if (!in_array($data['image']['type'], ['image/png', 'image/jpeg'])) {
                $errors['image'] = 'Поддерживаемые типы файлов: .png, .jpg';
            }
        } else {
            $errors['image'] = 'Загрузите картинку';
        }

        return $errors;
    }

    public static function uploadImages(Post $post, $file)
    {
        $postFolder = date('Y-m-d') . '-' . $post->slug;
        $uploadDir = IMAGES_PATH . DIRECTORY_SEPARATOR . $post->category->slug . DIRECTORY_SEPARATOR . date('Y') . DIRECTORY_SEPARATOR . $postFolder;
        $uploadFile = $uploadDir . DIRECTORY_SEPARATOR . $file['name'];

        if (!is_dir($uploadDir)) {
            @mkdir($uploadDir, 755);
        }

        if (move_uploaded_file($file['tmp_name'], $uploadFile)) {
            return $uploadFile;
        }

        return false;
    }

    public static function transformFiles()
    {
        $result = [];

        foreach ($_FILES as $fileName => $files) {
            $result[$fileName] = [];

            foreach ($files as $key => $values) {
                if (is_array($values)) {
                    foreach ($values as $index => $value) {
                        $result[$fileName][$index][$key] = $value;
                    }
                } else {
                    $result[$fileName][$key] = $values;
                }
            }
        }

        return $result;
    }
}