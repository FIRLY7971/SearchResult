<?php

class PostGenerator
{
    private $data;

    private $errors = [];

    public function __construct(Post $data)
    {
        $this->data = $data;
    }

    public function generatePage()
    {
        if (is_dir($this->getPostFolder())) {
            $this->errors['slug'] = 'Slug должен быть уникальным';
            return false;
        }

        return $this->createPostFolders() && $this->createPostFile();
    }

    private function createPostFolders()
    {
        $dirPath = $this->getPostFolder();

        if (is_dir($dirPath)) {
            return false;
        }

        return @mkdir($dirPath, 755);
    }

    private function createPostFile()
    {
        $content = $this->render($this->getTemplate(), [
            'post' => $this->data
        ]);

        if (!$content) {
            return false;
        }

        return file_put_contents($this->getPostFile(), $content);
    }

    private function getPostFolder()
    {
        return POSTS_PATH . $this->data->category->folder . DIRECTORY_SEPARATOR . '2021' . DIRECTORY_SEPARATOR . $this->data->slug;
    }

    private function getPostFile()
    {
        $fileName = date('Y-m-d') . '-' . $this->data->slug . '.html';
        return $this->getPostFolder() . DIRECTORY_SEPARATOR . $fileName;
    }

    private function render($template, $data)
    {
        if (!is_file($template)) {
            return '';
        }

        ob_start();
        extract($data);
        include $template;
        return ob_get_clean();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function getTemplate()
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'post.php';
    }
}