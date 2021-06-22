<?php
/**
 * @var Post $post
 */
?>
---
layout: post
title: <?= $post->title . "\n" ?>
description: <?= $post->description . "\n" ?>
categories: <?= $post->category->slug . "\n" ?>
catname: <?= $post->category->title . "\n" ?>
image: "<?= $post->image ?>"
thumb: "<?= $post->image ?>"
permalink: "blog/:categories/:year-:month-:day-:slug.html"
---

<?= $post->content ?>