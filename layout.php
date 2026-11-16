<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>{{ title }}</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<header class="head">
		<div class="head-in">
			<a class="logo" href="/">Rack</a>
			<nav class="nav">
				<a class="on" href="/">Bays</a>
				<a href="cabinet.html">Cabinet</a>
				<a href="admin.html">Admin</a>
			</nav>
			<form class="find" action="index.html" method="get">
				<label class="visually" for="q">Search</label>
				<input id="q" name="q" type="search" placeholder="Topic or post">
				<button class="btn" type="submit">Search</button>
			</form>
			<div class="who">
				<a href="profile.html">Ira Bell</a>
				<a href="login.html">Log out</a>
			</div>
		</div>
	</header>
	<main class="wrap">
		{{ content }}
	</main>
	<footer class="site-footer">
		<div class="foot-in"><a href="https://code.mu">code.mu</a> © 2026 Rack</div>
	</footer>
</body>
</html>
