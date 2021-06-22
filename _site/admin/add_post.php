<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'constants.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'CategoryHelper.php';
$categories = CategoryHelper::getCategories();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'PostHelper.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'PostGenerator.php';
    require_once __DIR__ . DIRECTORY_SEPARATOR . 'lib' . DIRECTORY_SEPARATOR . 'Post.php';

    $postImage = PostHelper::transformFiles();
    $errors = PostHelper::validatePost(array_merge($_POST, $postImage));

    if (!$errors) {
        $post = new Post($_POST);
        $post->category = CategoryHelper::getBySlug(@$_POST['category']);

        if ($imagePath = PostHelper::uploadImages($post, $postImage['image'])) {
            $imagePath = str_replace(DIRECTORY_SEPARATOR, '/', 'images' . substr($imagePath, mb_strlen(IMAGES_PATH)));

            $post->image = $imagePath;

            $postGenerator = new PostGenerator($post);
            $postGenerator->generatePage();

            $generatorErrors = $postGenerator->getErrors();

            if (isset($generatorErrors['slug'])) {
                $errors['slug'] = $generatorErrors['slug'];
            }
        } else {
            $errors['image'] = 'Ошибка загрузки изображения';
        }
    }
}
?>
<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="./add_post.php" enctype="multipart/form-data" method="post">
    <input type="text" name="title" placeholder="Название">
    <?php if ($errors['title']): ?>
        <div><?= $errors['title'] ?></div>
    <?php endif; ?>
    <input type="text" name="slug" placeholder="Slug">
    <?php if ($errors['slug']): ?>
        <div><?= $errors['slug'] ?></div>
    <?php endif; ?>
    <input type="text" name="description" placeholder="Описание">
    <?php if ($errors['description']): ?>
        <div><?= $errors['description'] ?></div>
    <?php endif; ?>
    <select name="category">
        <? foreach ($categories as $category): ?>
            <option value="<?= $category->slug ?>"><?= $category->title ?></option>
        <? endforeach; ?>
    </select>
    <?php if ($errors['category']): ?>
        <div><?= $errors['category'] ?></div>
    <?php endif; ?>
    <input type="file" name="image" multiple>
    <?php if ($errors['image']): ?>
        <div><?= $errors['image'] ?></div>
    <?php endif; ?>
    <textarea name="content" cols="30" rows="10"></textarea>
    <?php if ($errors['content']): ?>
        <div><?= $errors['content'] ?></div>
    <?php endif; ?>
    <button type="submit">Отправить</button>
</form>
</body>
</html>