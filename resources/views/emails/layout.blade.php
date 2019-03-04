<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>{{ Lang::get("application.name") }}</h2>

		<div>
			@yield('content')
		</div>

		<footer>
			{{ Lang::get("email.footer") }}
		</footer>
	</body>
</html>