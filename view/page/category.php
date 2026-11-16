<?php

    $content = '';
    
    $categorySlug = $params['categorySlug'];    
    
	// пагинация 
    // записей на странице 
    //$limit = $CONFIG['topics_per_page']; 
    $limit = 30;
    // текущая страница
    $sheet = isset($_GET['sheet']) ? (int)$_GET['sheet'] : 1; 
    if ($sheet < 1) $sheet = 1; 

    // общее количество записей   
    $query = "SELECT COUNT(*) as count 
    FROM topics
	LEFT JOIN
		categories ON categories.id=topics.category_id
	WHERE
		categories.slug='$categorySlug'";
	
	$res = mysqli_query($link, $query) or die(mysqli_error($link));
    $data = mysqli_fetch_assoc($res);
    
    $totalResults = (int)$data['count'];
    // всего страниц
    $totalPages = ceil($totalResults / $limit); 
    // смещение
    $offset = ($sheet - 1) * $limit; 
	
    
    $query = "SELECT topics.id, topics.slug, topics.name, topics.date, categories.name as categoryname, categories.id as categoryid, categories.description as categorydescription 
    FROM topics 
	LEFT JOIN
		categories ON categories.id=topics.category_id
	WHERE
		categories.slug='$categorySlug'
    ORDER BY id DESC
    LIMIT $limit OFFSET $offset";
	
	$res = mysqli_query($link, $query) or die(mysqli_error($link));

    for ($data = []; $row = mysqli_fetch_assoc($res); $data[] = $row);

    if(!empty($data)) {

    //var_dump ($data[0]);

        $content .= '<p class="meta"><a href="/">Bays</a> / ' . $data[0]['categoryname'] . '</p>';
        
        $categoryid = $data[0]['categoryid'];

        //include 'loginblock.php';
        
        $content .= '<h1>' . $data[0]['categoryname'] . '</h1>';

        $content .= '<p class="lead">' . $data[0]['categorydescription'] . '</p>';

        $content .= '<div class="acts" style="margin-bottom:16px">
			<a class="btn" href="create.html">Create a topic</a>
		</div>';

        $content .= '<table class="topics">
			<thead>
				<tr>
					<th>Topic</th>
					<th>Author</th>
					<th>Posts</th>
					<th>Last post</th>
				</tr>
			</thead>
			<tbody>';

        foreach ($data as $page) {
            $content .= '<tr>
					<td>' . '<a href="/' . $categorySlug . '/'  . $page['slug'] . '">' . $page['name'] . '</a>' . '<div class="meta">Opened Sep 10 · 176 views</div></td>
					<td><a class="who-link" href="profile.html">Ira Bell</a></td>
					<td>6</td>
					<td>Carl Ide · Sep 11, 06:55</td>
				</tr>';
        }


        $content .= '</tbody>
		</table>';

        //навигация пагинации 
        //$content .= getPagination($totalPages, $sheet);
/*
        $content .= '<ul class="list-topics">';

        foreach ($data as $page) {

            $content .= '
                <li class="list-topics-item">
                    ' . date("d.m.Y", strtotime($page['date'])) . ' -- <a href="/' . $categorySlug . '/'  . $page['slug'] . '">' . $page['name'] . '</a>';

            //если пользователь admin или moderator - размещаем линк на удаление темы 
            if (($_SESSION['status'] ?? '') == 'admin' OR ($_SESSION['status'] ?? '') == 'moderator') {                
                $content .= '<form action="/deletetopic" method="POST" style="display:inline;" onsubmit="return confirm(\'Удалить тему?\');">
                    <input type="hidden" name="topicid" value="' . $page['id'] . '">
                    <input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">                    
                    <button type="submit" style="color: red; background: none; border: none; cursor: pointer;">удалить</button>
                </form>';                
            }

            $content .= '</li>';
            
        }

        $content .= '</ul>';
*/        
        //навигация пагинации 
        //$content .= getPagination($totalPages, $sheet);      
    } else {        
        //в БД нет тем в данной категории, формируем другой запрос, чтобы получить название категории без связывания таблиц
        $query = "SELECT categories.name as categoryname, categories.id as categoryid  
        FROM categories        
        WHERE
            slug='$categorySlug'";
        
        $res = mysqli_query($link, $query) or die(mysqli_error($link));
        $page = mysqli_fetch_assoc($res);       

        $categoryid = $page['categoryid'];

        //include 'loginblock.php';
        
        //$content .= '<h1>Все темы категории "' . $page['categoryname'] . '"</h1>';

        $content .= '<p class="meta"><a href="/">Bays</a> / ' . $page['categoryname'] . '</p>';
        $content .= '<p>There are no topics in this category yet.</p>';
    }    
    
	$page = [
		'title' => 'Все темы категории ' . $page['categoryname'], 
		'content' => $content
	];    
    
	return $page;

?>