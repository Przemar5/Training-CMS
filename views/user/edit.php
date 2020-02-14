<main class="container py-5 px-4">
	<h1>Edit user</h1>

	<form action="<?php echo USER . '/update/' . $this->user['id']; ?>" method="post">
		<div class="form-group">
			<label for="login">Login:</label>
			<input type="login" class="form-control" id="login" name="login" value="<?php echo $this->user['login']; ?>">
			<small class="text-danger login-error">
				<?php Session::displayOnce(['user_errors', 'login']); ?>
			</small>
		</div>

		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" class="form-control" id="password" name="password" value="<?php echo $this->user['password']; ?>">
			<small class="text-danger password-error">
				<?php Session::displayOnce(['user_errors', 'password']); ?>
			</small>
		</div>

		<div class="form-group">
			<label for="role">Permissions:</label>
			<select class="form-control" id="role" name="role">
				<option value="default" <?php if ($this->user['role'] === 'default') echo 'selected'; ?>>Default</option>
				<?php if (Auth::verify('owner')): ?>
					<option value="admin" <?php if ($this->user['role'] === 'admin') echo 'selected'; ?>>Admin</option>					
					<option value="owner" <?php if ($this->user['role'] === 'owner') echo 'selected'; ?>>Owner</option>
				<?php endif; ?>
			</select>
		</div>

		<button type="submit" class="btn btn-block btn-primary">Update</button>
	</form>
</main>