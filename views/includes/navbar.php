		<nav role="navigation" class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="<?php echo BASE_URL; ?>index">
				My site
			</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

		  	<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav ml-auto">
					<?php if (Auth::verify('admin')): ?>
					
						<li class="nav-item <?php if ($this->isDashboard) echo 'active'; ?>">
							<a class="nav-link" href="<?php echo DASHBOARD; ?>">
								Dashboard 
								<?php if (isset($this->isDashboard) && $this->isDashboard === true): ?>
									<span class="sr-only">(current)</span>
								<?php endif; ?>
							</a>
						</li>

						<li class="nav-item <?php if ($this->isUser) echo 'active'; ?>">
							<a class="nav-link" href="<?php echo USER; ?>">
								Profile 
								<?php if (isset($this->isUser) && $this->isUser === true): ?>
									<span class="sr-only">(current)</span>
								<?php endif; ?>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="<?php echo LOGOUT; ?>">
								Log out
							</a>
						</li>
					
					<?php else: ?>
					
						<li class="nav-item <?php if ($this->isHome) echo 'active'; ?>">
							<a class="nav-link" href="<?php echo INDEX; ?>">
								Home 
								<?php if (isset($this->isHome) && $this->isHome === true): ?>
									<span class="sr-only">(current)</span>
								<?php endif; ?>
							</a>
						</li>

						<li class="nav-item <?php if ($this->isAbout) echo 'active'; ?>">
							<a class="nav-link" href="<?php echo ABOUT; ?>">
								About 
								<?php if (isset($this->isAbout) && $this->isAbout === true): ?>
									<span class="sr-only">(current)</span>
								<?php endif; ?>
							</a>
						</li>

						<li class="nav-item <?php if ($this->isContact) echo 'active'; ?>">
							<a class="nav-link" href="<?php echo CONTACT; ?>">
								Contact 
								<?php if (isset($this->isContact) && $this->isContact === true): ?>
									<span class="sr-only">(current)</span>
								<?php endif; ?>
							</a>
						</li>

						<li class="nav-item <?php if ($this->isLogin) echo 'active'; ?>">
							<a class="nav-link" href="<?php echo LOGIN; ?>">
								Login 
								<?php if (isset($this->isLogin) && $this->isLogin === true): ?>
									<span class="sr-only">(current)</span>
								<?php endif; ?>
							</a>
						</li>
					
					<?php endif; ?>
				</ul>
			</div>
		</nav>