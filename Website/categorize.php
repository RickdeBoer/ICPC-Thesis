<!DOCTYPE html>
<html lang="en">

  <head>
    <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>

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
    <script type="text/javascript">
      function setCookie(key, value) {
        var expires = new Date();
        expires.setTime(expires.getTime() + (1 * 24 * 60 * 60 * 9000));
        document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
      }

      function getCookie(key) {
        var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
        return keyValue ? keyValue[2] : null;
      }
      function delCookie(key,value) {
        var expires = new Date();
        expires.setTime(expires.getTime() - (1 * 24 * 60 * 60 * 9000));
      	document.cookie = key + '=' + value + ';expires=' + expires.toUTCString()
	    }
      function getAbbriv(){
        number = $("#problemabbriv").text();
        if(number == 1)
          return "A"
        else if(number == 2)
          return "B"
        else if(number == 3)
          return "C"
        else if(number == 4)
          return "D"
        else if(number == 5)
          return "E"
        else if(number == 6)
          return "F"
        else if(number == 7)
          return "G"
        else if(number == 8)
          return "H"
        else if(number == 9)
          return "I"
        else if(number == 10)
          return "J"
        else if(number == 11)
          return "K"
        else if(number == 12)
          return "L"
        else if(number == 13)
          return "M"
        else
          return("X")
      }

      $(function() { 
        var submittedamount = 0;  
        cookievalue = getCookie("username");  
        if(cookievalue == null){   
          $('#usernameModal').modal('show');
        }
        else {//cookie is available          
            $("#usernameP").text("Welcome ");
            $("#usernameA").text(cookievalue);
        }
        
        $("#submituserchangecancel").click(function(e){
            $('#changeusernameModal').modal('hide');
        });
        $("#usernameA").click(function(e){
            $('#changeusernameModal').modal('show');
          $("#usernameInput2").val(getCookie("username"));
        });

        $("#usernameform2").on('submit', function(e){
            e.preventDefault();
            cookievalold = getCookie("username"); 
            delCookie("username",cookievalold)

            setCookie("username", $("#usernameInput2").val());

            $("#usernameP").text("Welcome ");
            $("#usernameA").text($("#usernameInput2").val());
            $('#changeusernameModal').modal('hide');
        });

        $("#usernameform").on('submit', function(e){
            e.preventDefault();
            setCookie("username", $("#usernameInput").val());

            $("#usernameP").text("Welcome ");
            $("#usernameA").text($("#usernameInput").val());
            
            $('#usernameModal').modal('hide');
        });



       $("#icpcarchiveiframe").on('load',function(){
         $(this).contents().on("click", 'a', function(){
          //if link is to problem page, log its index
          if(String(this).indexOf('.pdf') == -1 && (String(this).indexOf('page=show_problem') != -1 || String(this).indexOf('2018') != -1)){
            $("#problemabbriv").text($(this).parents("tr:first").index());
            }
         });
       });      

        $('#infoform').on('submit', function(e) {
            e.preventDefault();

            if(getCookie("username") == null){
              alert("Username not set, please provide a username before submitting data")
              $('#usernameModal').modal('show');
            }
            else if(submittedamount > 50){
              alert("There are already 50 or mor submissions received for this problem. This is likely due to an DOS attack or error. Please contact the website owner if this message persists")
            }
            else{
            var dataArray = $("#infoform :input").serializeArray();
            var dataObj = {};
            var unknowns = 0;

            $(dataArray).each(function(i, field){
              if(field.value == "Unknown")
                unknowns += 1
              dataObj[field.name] = field.value;
            });

            if(unknowns > 2){//check if multiple are unknown in dataObj
              alert("3 or more values are not filled, please provide more information")
            }
            else{

              var categories = $("#problemcategory").val().substring(0, 500);
              var problemname = $("#problemname").text();
              var problemseenbefore = $('#problemseen_checkbox').is(":checked");

              var problemnameindex = $("#problemname").text().indexOf(" - ")

              var timelimit = $("#timelimit").text();
              
              $.ajax({
                type: "POST",
                url: "dbcommunication.php",
                data: { action: 'add_to_db',
                        userid: getCookie("username"),
                        year: $("#contestyear").text(),
                        competition: $("#contestname").text(),
                        problemname: problemname.substring(problemnameindex+3),
                        problemid: problemname.split(" ")[0],
                        category: categories,
                        timelimit: timelimit,
                        problemseen: problemseenbefore,
                        problemabbriv: getAbbriv(),
                        userinputs: dataObj }
                }).done(function( msg ){ 
                  if(msg == "Success!" || msg.indexOf("Success!") !== -1) { 
                    $('#thankyou').show(); 
                    var counter = 2;
                    var interval = setInterval(function() {
                        counter--;
                        if (counter == 0) {
                            // Display a login box
                            $("#thankyou").fadeOut("slow");
                            clearInterval(interval);
                            $('#infoform').trigger("reset"); //clear when done
                            copyIframeContent();
                        }
                    }, 1000);   
                  }
                  else if(msg == "submissionlimit"){
                    alert("Submission limit reached, over 150 submissions are received from you and data will no longer be added to the database. This is a safety measure to counter DOS attacks.")
                  }
                  else{
                    alert("Something went wrong. Apologies for the inconvenience, we'll fix this as soon as possible.")
                    console.log(msg)
                  }             
              }); 
            }// end of else 
          }//end of first else
        });//end of function()
      });      
      
      function copyIframeContent(){ 
        //Get the info from the iframe
        var contents = document.getElementById('icpcarchiveiframe').contentWindow.document.body.innerHTML;

        iframemeta = $(contents).find("td.maincontent table tbody :nth-child(2) td");
        if($(iframemeta).length == 1){ //problem page
        
          var contestname = "";
          var problemname = "";
          var contestyear = "";
          var count = 1;

          //get timelimit          
          var x = iframemeta.html();
          var i0 = x.indexOf("Time limit: ")
          var i1 = x.indexOf(" seconds")
          var timelimit = x.substring(i0+12,i1);

          $(iframemeta).find("a").each(function(i)
          {
            if(count == 1){ //year
              contestyear = $(this).html().split(" ")[1];
            }
            else if(count == 2){ //region
              if($(this).html().indexOf("-") != -1){
                ay = $(this).html().split(" - ");
                contestname = ay[1] + " " + ay[0];
              }
              else
                contestname = $(this).html();
            }
            count += 1;
          });
          problemname = $(iframemeta).find("h3").html();
          $("#contestname").text(contestname);
          $("#problemname").text(problemname);

          if(contestyear == "finals" || contestyear == "Finals" || contestyear == "finals " || contestyear == "Finals "){
            var lastspace = contestname.lastIndexOf(" ")
            var length = contestname.length
            contestyear = contestname.substring(lastspace+1,length);
            $("#contestname").text(contestname.substring(0,lastspace));
          }

          $("#contestyear").text(contestyear);
          $("#timelimit").text(timelimit);
          $("#descriptionhelp").text("");
          $("#submitbutton").show();
          
          $.ajax({
            type: "POST",
            url: "dbcommunication.php",
            data: { action: 'problem_already_analysed',
                    problemid: problemname.split(" ")[0] }
          }).done(function( solvedamount ) {
            if(solvedamount > 0 && solvedamount < 50){
              $("#descriptionhelp").html("<h5 style='color:orange;'>This problem is analysed " + solvedamount +" times before.</h5><h6>Problems that are not analysed are more important and preferred</h6>");
            }
            else if(solvedamount > 0 && solvedamount > 50){
              $("#descriptionhelp").html("<h5 style='color:red;'>This problem is already analysed " + solvedamount +" times, submissions are disabled</h5>This is most likely due to an error or DOS attack.");
              submittedamount = solvedamount;
            }
            else{
              $("#descriptionhelp").html("");
            }
          });  
        }
        else{
          if(document.getElementById("icpcarchiveiframe").contentWindow.location.href.lastIndexOf(".pdf") == -1){
            $("#contestname").html("<i>Contest name</i>");
            $("#problemname").html("<i>Problem name</i>");
            $("#contestyear").html("<i>Year</i>");
            $("#timelimit").text();
            $("#descriptionhelp").html("Information will appear when on a problem page");
            $("#submitbutton").hide();
          }
        } 
      }   
        
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
                  <p style="margin: 8px; color: white;"><span id="usernameP"></span> <a style="text-decoration:underline; cursor: pointer;" id="usernameA"></a></p>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-info my-2 my-sm-0 active" href="categorize.php">Categorize</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-info my-2 my-sm-0" href="contributors.php">Contributors</a>
                </li>
            </ul>
        </div>
    </nav>

<!-- Modal -->
<div id="usernameModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Name</h4>
      </div>
      <div class="modal-body">
        <p>Choose a username. If you want to be accredited, please provide your full name. If not, type in any nickname.</p>
        <form id="usernameform" method="post">
          Name: <input id="usernameInput" type="text" pattern=".{3,}" maxLength="100" required title="3 characters minimum">
          <button type="submit" id='submitusernamebutton' style="margin-top:-5px;" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

  </div>
</div>

<!-- Change Modal -->
<div id="changeusernameModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Change username</h4>
      </div>
      <div class="modal-body">
        <form id="usernameform2" method="post">
          Name: <input id="usernameInput2" type="text" pattern=".{3,}" maxLength="100" required title="3 characters minimum">
          <button type="submit" id='submitusernamebutton2' style="margin-top:-5px;" class="btn btn-primary">Submit</button>
          <button id='submituserchangecancel' style="margin-top:-5px;" class="btn btn-default">Cancel</button>
        </form>
      </div>
    </div>

  </div>
</div>

    <section class="bg-light text-center" style="margin-top:20px;">
      <div class="col-12">
        <div class="row">
          <div class="col-md-7 col-xs-7">
            <h4 id="icpclocation">Navigate the problems here</h4>
            <small class="form-text text-muted">Click on the links to navigate through the problem repository from <a href="https://icpcarchive.ecs.baylor.edu/index.php?option=com_onlinejudge&Itemid=8">livearchive</a></small>
            <div id="iframecontainer">
           <iframe class="second-row" id="icpcarchiveiframe" onload="copyIframeContent();" name="icpcarchiveiframe" src="icpcwebarchive\icpcarchive.ecs.baylor.edu\index64a5.html" style="border:none;height:90%;"></iframe>
       		</div>
           <div><i>Content mirrored from <a href="https://icpcarchive.ecs.baylor.edu/index.php?option=com_onlinejudge&Itemid=8">https://icpcarchive.ecs.baylor.edu/index.php</a></i></div>
          </div>
          <div class="col-md-4 col-xs-4">
            <div class="form-group">
                <label id="contestname" style="font-size:18px;">Contest name</label> - <label style="font-size:18px;" id="contestyear">Year</label></br>
                <label id="timelimit" style="display:none;"></label>
                <label id="problemabbriv" style="display:none;"></label>
                <label id="problemname" style="font-size:26px; font-weight:bold;margin-top:0px;line-height:initial;" aria-describedby="descriptionhelp" >Problem name</label></br>
                <small id="descriptionhelp" class="form-text text-muted">Information will load automatically</small>
                <hr>
              <form id="infoform" method="post">
                <label for="problemcategory" style="font-size:18px;margin-top:0px">Problem category</label> 
                <small id="problemcategoryhelp" class="form-text text-muted">If multiple categories fit, separate them with a comma, e.g. "dynamic programming, geometry"</small>
                <input type="text" class="form-control" id="problemcategory" maxLength="200"
                aria-describedby="problemcategoryhelp" placeholder="Enter one or more problem categories here" required>

                <label id="inputreadinglabel" style="font-size:18px;margin-top:10px;margin-bottom:0px" >Easiness of manipulating input and output</label> </br>
                <input type="radio" id="inputreadinglabel_unknown" name="inputandoutputmanipulation" value="Unknown" checked>
                <label for="inputreadinglabel_unknown"><i>Unknown</i></label>
                <input type="radio" id="inputreadinglabel_easy" name="inputandoutputmanipulation" value="Easy">
                <label for="inputreadinglabel_easy">Easy</label>
                <input type="radio" id="inputreadinglabel_medium" name="inputandoutputmanipulation" value="Medium">
                <label for="inputreadinglabel_easy">Medium</label>
                <input type="radio" id="inputreadinglabel_hard" name="inputandoutputmanipulation" value="Hard" >
                <label for="inputreadinglabel_hard">Hard</label> </br>

                <label id="codingamountlabel" style="font-size:18px;margin-top:10px;margin-bottom:0px">Amount of coding required</label> </br>
                <input type="radio" id="codingamountlabel_unknown" name="codingamount" value="Unknown" checked>
                <label for="codingamountlabel_unknown"><i>Unknown</i></label>
                <input type="radio" id="codingamountlabel_easy" name="codingamount" value="Little">
                <label for="codingamountlabel_easy">Little</label>
                <input type="radio" id="codingamountlabel_medium" name="codingamount" value="Medium">
                <label for="codingamountlabel_easy">Medium</label>
                <input type="radio" id="codingamountlabel_hard" name="codingamount" value="Large" >
                <label for="codingamountlabel_hard">Large</label> </br>

                <label id="sophisticatedlabel" style="font-size:18px;margin-top:10px;margin-bottom:0px;line-height: 1;">Easiness of identifying the proper algorithmic solution</label> </br>
                <input type="radio" id="sophisticatedlabel_unknown" name="sophisticated" value="Unknown" checked>
                <label for="sophisticatedlabel_unknown"><i>Unknown</i></label>
                <input type="radio" id="sophisticatedlabel_easy" name="sophisticated" value="Easy">
                <label for="sophisticatedlabel_easy">Easy</label>
                <input type="radio" id="sophisticatedlabel_medium" name="sophisticated" value="Medium">
                <label for="sophisticatedlabel_easy">Medium</label>
                <input type="radio" id="sophisticatedlabel_hard" name="sophisticated" value="Hard" >
                <label for="sophisticatedlabel_hard">Hard</label> </br>

                <label id="hardnesslabel" aria-desribedby="hardnesshelp" style="font-size:18px;margin-top:10px;margin-bottom:0px">Overall difficulty of this problem</label> </br>
                <small id="hardnesshelp" class="form-text text-muted" style="margin-top:0px;margin-bottom:0px">1=Very easy, 5=Very hard </small>
                <label for="hardnesslabel_hard1">1</label>
                <input type="radio" id="hardnesslabel_hard1" name="hardness" value="1" required>
                <input type="radio" id="hardnesslabel_hard2" name="hardness" value="2">
                <input type="radio" id="hardnesslabel_hard3" name="hardness" value="3">
                <input type="radio" id="hardnesslabel_hard4" name="hardness" value="4">
                <input type="radio" id="hardnesslabel_hard5" name="hardness" value="5">
                <label for="hardnesslabel_hard5">5</label> </br>

                <input type="checkbox" id="problemseen_checkbox" name="problemseen" value="Yes" >
                <label id="problemseenlabel" style="font-size:18px;margin-top:10px;margin-bottom:0px;line-height: 1;">I have seen this problem before</label>
              <div style="display:none;font-size:20px;margin-top:5px;" id="thankyou">
                <h6 style="margin:0px;">Data submitted succesfully, thank you!</br> 
                  <i>Resetting Form </i><img src="img/loading.gif" style="height:30px;width:30px;"></h6>
              </div></br>
              <button type="submit" id='submitbutton' style="margin-top:5px;display:none;" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
      </div>
    </section>


    <!-- Footer -->
    <footer class="footer bg-light" style="margin-top:20px;">
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
