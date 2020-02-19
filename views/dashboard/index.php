<main class="container py-5 px-4">
	<h1>Dashboard</h1>
	
	<div class="row">
		<div class="offset-lg-1 col-lg-4 order-lg-2 my-4">
			<h3>Add new user</h3>
			
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
						<?php if (Auth::verify('owner')): ?>	
							<option value="admin">Admin</option>					
							<option value="owner">Owner</option>
						<?php endif; ?>
					</select>
			  	</div>
				
				<button type="submit" class="btn btn-block btn-primary">Create</button>
			</form>
		</div>
		
		<div class="col-lg-7 order-lg-1">
			<?php if (count($this->users)): ?>
	
				<table class="table table-hover">
					<thead>
						<tr>
							<th>
								user id
							</th>
							<th>
								login
							</th>
							<th>
								role
							</th>
							<th>

							</th>
						</tr>
					</thead>

					<tbody>
						<?php if (!isset($this->users['id'])): ?>
							<?php foreach ($this->users as $user): ?>
								<tr>
									<td>
										<?php echo $user['id']; ?>
									</td>
									<td>
										<?php echo $user['login']; ?>
									</td>
									<td>
										<?php echo $user['role']; ?>
									</td>
									<td class="float-right">
										<?php if (Auth::hasPermission($user) || Auth::samePerson($user['id'])): ?>
											<a href="<?php echo USER . '/edit/' . $user['id']; ?>" class="btn btn-sm btn-primary mr-3">
												Edit
											</a>
											<a href="<?php echo USER . '/delete/' . $user['id']; ?>" class="btn btn-sm btn-danger">
												Delete
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td>
									<?php echo $this->users['id']; ?>
								</td>
								<td>
									<?php echo $this->users['login']; ?>
								</td>
								<td>
									<?php echo $this->users['role']; ?>
								</td>
								<td class="float-right">
									<?php if (Auth::hasPermission($this->users) || Auth::samePerson($this->users['id'])): ?>
										<a href="<?php echo USER . '/edit/' . $this->users['id']; ?>" class="btn btn-sm btn-primary mr-3">
											Edit
										</a>
										<a href="<?php echo USER . '/delete/' . $this->users['id']; ?>" class="btn btn-sm btn-danger">
											Delete
										</a>
									<?php endif; ?>
								</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>

			<?php endif; ?>
		</div>
	</div>
</main>