<?php
// No need to call session_start() here if it's already called in index.php
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container">
    <a class="navbar-brand" href="./">
      <img src="./public/logo.png" />
    </a>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="./">Home</a>
        </li>
        <?php if (isset($_SESSION['user']) && $_SESSION['user']['username']) { ?>
          <li class="nav-item">
            <a class="nav-link" href="./server/requests.php?logout=true">
              Logout (<?php echo ucfirst($_SESSION['user']['username']); ?>)
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?ask=true">Ask A Question</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?u-id=<?php echo $_SESSION['user']['user_id']; ?>">My Questions</a>
          </li>
        <?php } else { ?>
          <li class="nav-item">
            <a class="nav-link" href="?login=true">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="?signup=true">SignUp</a>
          </li>
        <?php } ?>

        <li class="nav-item">
          <a class="nav-link" href="?latest=true">Latest Questions</a>
        </li>
      </ul>
    </div>
    <form class="d-flex" action="">
      <input style="margin-bottom:10px;width:800px" class="form-control me-2" name="search" type="search" placeholder="Search questions">
      <button style="width:100px" class="btn btn-outline-success" type="submit">Search</button>
    </form>
  </div>
</nav>