<main class="container py-5 px-4">
	<h1>Add new user</h1>

	<form action="<?php echo USER; ?>/create" method="post">
		<div class="form-group">
			<label for="login">Login:</label>
			<input type="login" class="form-control" id="login" name="login">
			<small class="text-danger login-error">
				<?php Session::displayOnce(['user_errors', 'login']); ?>
			</small>
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" class="form-control" id="password" name="password">
			<small class="text-danger password-error">
				<?php Session::displayOnce(['user_errors', 'password']); ?>
			</small>
		</div>

		<div class="form-group">
			<label for="role">Permissions:</label>
			<select class="form-control" id="role" name="role">
				<option value="default" selected>Default</option>
				<option value="admin">Admin</option>
				<?php if (Auth::verify('owner')): ?>						
					<option value="owner">Owner</option>
				<?php endif; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-block btn-primary">Create</button>
	</form>
</main>