<?php
session_start();
include_once "sqlLib.php";
$sqlLib = new sqlLib();

if (isset($_POST["signin"])) {
  $userid = $_POST["userid"];
  $password = $_POST["password"];
  $password = substr(md5($password), 1, 11);

  $sqluser = "SELECT UserID FROM ms_user WHERE UserID ='" . $userid . "' AND Aktif ='1' ";
  //echo $sqluser;
  $datauser = $sqlLib->select($sqluser);
  if (count($datauser) > 0) {
    $sqlpass = "SELECT a.UserID, a.Nama, a.Level, a.Image
                FROM ms_user a 
                WHERE  a.UserID ='" . $userid . "' AND  a.Password = '" . $password . "' ";
    $datapass = $sqlLib->select($sqlpass);
    if (count($datapass) > 0) {

      $_SESSION["userid"] = $datapass[0]["UserID"];
      $_SESSION["nama"]   = $datapass[0]["Nama"];
      $_SESSION["level"]  = $datapass[0]["Level"];
      $_SESSION["image"]  = $datapass[0]["Image"];
      
      setcookie("userid", $datapass[0]["UserID"], time() + (3600 * 24 * 30 * 12));
      setcookie("nama", $datapass[0]["Nama"], time() + (3600 * 24 * 30 * 12));
      setcookie("level", $datapass[0]["Level"], time() + (3600 * 24 * 30 * 12));
      setcookie("image", $datapass[0]["Image"], time() + (3600 * 24 * 30 * 12));
      header("location:index.php");
    } else {
      $alert = 1;
      $note  = "Password salah!!";
    }
  } else {

    $alert = 1;
    $note  = "UserID tidak ditemukan/tidak aktif!!";
  }

}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>LELA FURNITURE</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="index.php"><b>LELA FURNITURE</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">

      <?php
      if ($alert == "0") {
      ?><div class="form-group">
          <div class="alert alert-success alert-dismissible">
            <?php echo $note ?>
          </div>
        </div><?php
            } else if ($alert == "1") {
              ?><div class="form-group">
          <div class="alert alert-danger alert-dismissible">
            <?php echo $note ?>
          </div>
        </div><?php
            }
              ?>

      <p class="login-box-msg">Silahkan Masuk</p>

      <form method="post" autocomplete="off">

        <div class="form-group has-feedback">
          <input type="text" class="form-control" placeholder="ID Pengguna" name="userid" required="required">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Kata Sandi" name="password" required="required">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-xs-8">

          </div>
          <!-- /.col -->
          <div class="col-xs-4">
            <button type="submit" name="signin" class="btn btn-primary btn-block btn-flat">Masuk</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <!-- jQuery 3 -->
  <script src="bower_components/jquery/dist/jquery.min.js"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
  <!-- iCheck -->
  <script src="plugins/iCheck/icheck.min.js"></script>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
      });
    });
  </script>
</body>

</html>