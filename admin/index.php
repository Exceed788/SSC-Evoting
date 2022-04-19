<?php 
define( 'SEND_TO_HOME', true );
require_once '../session.php';
require_once '../auth.php';    
?>
<!Doctype html>
<html>
  <?php include '../shared/head.php'; ?>
  <style>
    .login{
      min-height:300px;
      border-radius:4px;
      box-shadow:0px 0px 2px black;
      padding:10px;
      padding-bottom:10px;
      background-color:white;
      width:320px;
      position:absolute;
      top:250px;
      left: calc(50% - 160px);

    }
    .head{
      height:300px;
    }
    body{
      opacity: 1;
    }
    #logo {
      position:fixed;
      left:20px;
      top:20px;
    }
  </style>
<body style="background-image: url('../imgs/bl.jpg'); background-repeat: no-repeat; background-attachment: fixed; background-size: cover; background-position: center;"> 
  
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
  
    
  </div>
  <div> 

  <div class="login">

          <center><b> <h4 class="mt-2">Web Based Voting</h4><h5>Admin Login<h5></b></center>
          
          <form method="" action="" id="loginForm">
            <div class="form-group">
              <label for="userName">Username</label>
              <input class="form-control" id="userName" name="username" placeholder="Input Username" required>
            </div>
            <div class="form-group">
              <label for="userName">Password</label>
              <input class="form-control" type="password" id="password" name="password" placeholder="Input Password" required >
              <input style="margin-top: 10px;" type="checkbox" onclick="myFunction()">Show Password
            </div>
             <button  type="submit" class="btn btn-primary btn-block">Login</button>

          </form>
          <a class="btn btn-secondary"  style="width:300px; margin-top: 10px;" href="http://localhost/dynamic/vote/vote-page.php"type="submit">Login as student</a>
  </div>
  </div>
    <?php include '../shared/foot.php'; ?>
    <?php include '../shared/alert.php'; ?>
    <script>
        $("#loginForm").on('submit', function(e){  
            e.preventDefault();
            let data = $("#loginForm");
            let formData = new FormData(data[0]);
            $.ajax({
                method: "POST",
                url: "../process/LoginRoutes.php",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(e, status, xhr){
                    console.log(status);
                    if(e == 'Username'){
                        alertService.alert({response:"success",message:"Username does not exist!"});
                    } else if(e == 'error'){
                        alertService.alert({response:"success",message:"Incorrect Username or Password!"});
                    } else {
                        window.location.href='dashboard.php';
                    }
                    
                },
                error: function(e, status, xhr){
                    alertService.alert({response:"success",message:"Incorrect Username or Password!"});
                }
            });
        });

function myFunction() {
  var x = document.getElementById("password");
  if (x.type === "password") {
    x.type = "text";
  } else {
    x.type = "password";
  }
}

    </script>
</body>
</html>