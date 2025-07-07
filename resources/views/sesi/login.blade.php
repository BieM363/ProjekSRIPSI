<!DOCTYPE HTML>
<html>
	<head>
		<title>Eventually by HTML5 UP</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="/assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper">

				<!-- Header -->
					<header id="header">
						<h1>Hallo, Selamat Datang di ....</h1>
						<p>Login untuk masuk</p>
						 @if($errors->any())
        					<div style="color: red;">
            					{{ $errors->first() }}
       						 </div>
   						 @endif
					</header>

				<!-- Login Form -->
				<form id="signup-form" form method="POST" action="{{ url('/login') }}">
					 @csrf
					<label>Email</label><br>
					<input type="email" name="email" value="{{ old('email') }}" required><br><br>

					<label>Password</label><br>
        			<input type="password" name="password" required><br><br>
					
					<input type="submit" value="Login" class="btn"/>
				</form>
			</div>

		<!-- Scripts -->
			<script src="/assets/js/main.js"></script>

	</body>
</html>