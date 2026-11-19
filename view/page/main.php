<?php

$content = '';

$content .= '<h1>Bays</h1>';
$content .= '<p class="lead">Shop talk for boxes, wires, and tickets. Icons are color blocks.</p>';

//$query = "SELECT slug, name, description, ico FROM categories";
$query = "SELECT 
    c.slug, 
    c.name, 
    c.description, 
    c.ico,
    COUNT(t.id) AS topic_count
FROM categories c
LEFT JOIN topics t ON c.id = t.category_id
GROUP BY c.id";	
$res = mysqli_query($link, $query) or die(mysqli_error($link));	
for ($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);

$content .= '<div class="cats">';
	foreach ($data as $category) {
        $content .= '
            <a class="cat" href="/' . $category['slug'] . '">
				<div class="ico">' . $category['ico'] . '</div>
				<div>
					<h2>' . $category['name'] . '</h2>
					<p class="meta">' . $category['description'] . '</p>
				</div>
				<div class="n">' . $category['topic_count'] . '</div>
			</a>
        ';        
	}
$content .= '</div>';

$page = [
		//'title' => $CONFIG['forum_title'] . ' - главная', 
        'title' => 'Rack — IT forum', 
		'content' => $content
	];
	
return $page;

?>