<main class="container py-5 px-4">
	<h1>Login</h1>

	<form action="login/verify" method="post">
		<div class="form-group">
			<label for="login">Login:</label>
			<input type="text" name="login" class="form-control" id="login">
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" class="form-control" id="password">
		</div>

		<div class="checkbox">
			<label>
				<input type="checkbox" name="remember"> Remember me
			</label>
		</div>

		<button type="submit" class="btn btn-default">Login</button>
	</form>
</main>