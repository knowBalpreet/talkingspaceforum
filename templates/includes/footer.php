      				</div>
      			</div>
      		</div>
      		<div class="col-md-4">
	      		<div class="sidebar">
      				<div class="block">
						<h3>Login Form</h3>
            <?php if (isLoggedIn()) { ?>
            <div class="userdata">
              Welcome, <?php echo getUser()['username'];?>
              <br><br>
              <form role="form" method="POST" action="<?php echo BASE_URI;?>/logout.php">
                <input type="submit" name="do_logout" class="btn btn-primary" value="Logout">
              </form>
            </div>
            <?php   }else{  ?>
						<form role="form" method="POST" action="<?php echo BASE_URI;?>/login.php">
						<div class="form-group">
							<label>Username</label>
							<input name="username" type="text" class="form-control" placeholder="Enter Username">
						</div>
						<div class="form-group">
							<label>Password</label>
							<input name="password" type="password" class="form-control" placeholder="Enter Password">
						</div>			
						<button name="do_login" type="submit" class="btn btn-primary">Login</button>
						<a  class="btn btn-default" href="register.php"> Create Account</a>
						</form>
            <?php  } ?>
      				</div>
      				<div class="block">
      					<h3>Categories</h3>
                <div class="list-group">
                  <a href="topics.php" class="list-group-item <?php echo is_active(null) ?>">All Topics <span class="badge pull-right"><?php echo $totalTopics ?></span></a>
                  <?php foreach (getCategories() as $category){ ?>
                  <a href="topics.php?category=<?php echo $category->id ?>" class="list-group-item <?php echo is_active($category->id) ?>"><?php echo $category->name ?></a>
                  <?php } ?>
                </div>
      				</div>		
    	  		</div>
      		</div>
      	</div>
      </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
