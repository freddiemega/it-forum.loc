<?php

$content = '';

$content .= '<h1>Bays</h1>';
$content .= '<p class="lead">Shop talk for boxes, wires, and tickets. Icons are color blocks.</p>';

$query = "SELECT slug, name, description, ico FROM categories";	
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
				<div class="n">48</div>
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