 <!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ICPC problem categorizer</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link href="css/customCSS.css" rel="stylesheet">

  </head>

  <body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
	    <div class="mx-auto order-0">
	        <a class="navbar-brand mx-auto" href="index.php">ICPC problem categorization</a>
	        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
	            <span class="navbar-toggler-icon"></span>
	        </button>
	    </div>
	    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
	        <ul class="navbar-nav ml-auto">
	            <li class="nav-item">
	                <a class="nav-link btn btn-info my-2 my-sm-0" href="categorize.php">Categorize</a>
	            </li>
	            <li class="nav-item">
	                <a class="nav-link btn btn-outline-info my-2 my-sm-0"" href="contributors.php">Contributors</a>
	            </li>
	        </ul>
	    </div>
	</nav>

    <!-- Masthead -->
    <header class="masthead text-white text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 class="mb-5">Thank you for visiting and helping!</h1>
          </div>
          <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
           <h4>For our research, we aim to categorize problems from the ICPC worldwide and regional contests such as those from Europe and Latin-America. All information will be made publicly available for research. Thank you very much for your help!</h4>
           <form action="categorize.php"">
			    <input type="submit" class="btn btn-block btn-lg btn-primary" value="Start categorizing" />
			</form>
          </div>
        </div>
      </div>
    </header>


    <section class="features-icons bg-light text-center">
     <h1>This information will be:</h1>
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-screen-desktop m-auto text-primary"></i>
              </div>
              <h3>Made publicly available</h3>
              <p class="lead mb-0">All information gathered so far and input gained from this website, will be available to the online research community.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-graph m-auto text-primary"></i>
              </div>
              <h3>Be researched</h3>
              <p class="lead mb-0">Problem categories will be used to expand ICPC scoreboards and standings with additional information to be researched for a MSc thesis.</p>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="features-icons-item mx-auto mb-0 mb-lg-3">
              <div class="features-icons-icon d-flex">
                <i class="icon-user m-auto text-primary"></i>
              </div>
              <h3>Be properly accredited</h3>
              <p class="lead mb-0">Unless desired to remain anonymous, participants will be accredited in the thesis, in the dataset description and on this website.</p>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- Footer -->
    <footer class="footer bg-light">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 h-100 text-center my-auto">
            <ul class="list-inline mb-2">
              <li class="list-inline-item">
                <a href="index.php">Home</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="categorize.php">Categorize</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="contributors.php">Contributors</a>
              </li>
              <li class="list-inline-item">&sdot;</li>
              <li class="list-inline-item">
                <a href="contact.php">Contact</a>
              </li>
            </ul>
            <p class="text-muted small mb-4 mb-lg-0">&copy; 2019. All Rights Reserved.</p>
          </div>
        </div>
      </div>
    </footer>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  </body>

</html>
