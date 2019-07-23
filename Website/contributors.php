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
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">
      $(function() { 
       $.ajax({
         type: "POST",
         url: "dbcommunication.php",
         data: { action: 'get_users'}
       }).done(function(rows){
         $("#loadingtr").remove();
         if(rows == 'end'){
             $("#contributorstable").find('tbody').append('<tr><td>'+'No contributors yet'+'</td><td></td></tr>');
           }
         else{
           rows = rows.split("<!br?>")
           for(var i=0;i<rows.length;i++){
             if(rows[i] != "end"){
               both = rows[i].split("|"); //0 is username and 1 is amount
               $("#contributorstable").find('tbody').append('<tr><td>' + both[0] + '</td><td>'+both[1]+'</td></tr>');
             }
           }                
         }
       }); 
      });
    </script>

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
                  <a class="nav-link btn btn-outline-info my-2 my-sm-0" href="contributors.php">Contributors</a>
              </li>
          </ul>
      </div>
  </nav>

    <!-- Masthead -->
    <header class="text-center">
      <div class="overlay"></div>
      <div class="container">
        <div class="row">
          <div class="col-xl-9 mx-auto">
            <h1 style="margin-top:15px;margin-bottom:10px;">Contributors</h1>
            <h5 style="font-weight: normal;">A big thank you to those who contributed! :)</h5>
          </div>
          <div style="margin-bottom:15px;" class="col-md-10 col-lg-8 col-xl-7 mx-auto">
            <small>This table is updated manually every once in a while</small>
            <table class="table table-striped" id="contributorstable">             
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Nr. of problems analyzed</th>
                </tr>
              </thead>
              <tbody>
                <tr id="loadingtr" style=""><td><i>Loading information</i> <img src="img/loading.gif" style="height:30px;width:30px;"></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </header>

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
