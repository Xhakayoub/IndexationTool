<?php

include 'lire_corpus.php';

// Connexion base de donnée 
$bdd = mysqli_connect('localhost', 'root', '', 'tiw');

// Insertion BDD
if(isset($_POST["add"]))
{
		$dossier = $_POST["rep"];
    lire_corpus($dossier);
    
}


// Supprimer tout BDD
if(isset($_POST["delete"]))
{
		
		$sql1 = "DELETE FROM `mot`";
		mysqli_query($bdd, $sql1);
		$sql2 = "DELETE FROM `document`";
		mysqli_query($bdd, $sql2);
		$sql3 = "DELETE FROM `mot_document`";
		mysqli_query($bdd, $sql3);
}




?>

<html lang="en">
<head>
  <title>Ayoub Indexation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
</head>
<style>
@font-face {
  font-family: myFirstFont;
  src: url(Neou-Bold.otf);
}
body{
  font-family: myFirstFont;
}
.form-control:focus {
  background-color: #262626;
  border-color:black;
  color:white;

}
</style>
<body style="background-color:#b3b3b3; background-image:url('back1.jpg');">

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">
    <img src="logo.png" alt="logo" style="width:90px;">
  </a>
  
  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="#">Home</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="search.php">Search</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#">About</a>
    </li>
  </ul>
</nav>

<br/><br/><br/>

<div class="container">


<form action="" method="post" enctype="multipart/form-data">
    <br><br><br><br><br><br><br><br><br><br>
    <input type="text" class="form-control" name="rep" id="rep"><br>
    <button class="btn btn-dark btn-block" type="submit" value="Indexation" name="add" type="submit"  value="Indexation" name="add" > Indexation </button><br>
    <button class="btn btn-dark btn-block" type="submit" value="Indexation" name="delete" type="submit"  value="Indexation" name="delete" > Delete BD </button><br>
</form>



<br/>
<?php

?>
</div>

</body>
</html>
<br/>
<br/>