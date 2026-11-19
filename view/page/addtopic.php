<?php

$content = '';


//var_dump($_SESSION);

$content .= '<div class="box">';
$content .= '<h1>Create a topic in Linux</h1>';
$content .= '<form action="" method="post">';
$content .= '<label for="topic-title">Title</label>';
$content .= '<input id="topic-title" name="title" type="text">';
$content .= '<label for="topic-body">First post</label>';
$content .= '<textarea id="topic-body" name="body" rows="10"></textarea>';
$content .= '<div class="acts">';
$content .= '<button class="btn" type="submit">Publish</button>';
$content .= '<a class="ghost" href="category.html">Cancel</a>';
$content .= '</div>';
$content .= '</form>';
$content .= '</div>';


$page['title'] = 'Создать тему на форуме';
$page['content'] = $content;

return $page;

?>