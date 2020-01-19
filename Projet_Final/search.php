
<?php

// Connexion base de donn�e 
$bdd = mysqli_connect('localhost', 'root', '', 'tiw');
		


?>
<html lang="en">
<head>
  <title>Search Ayoub Indexation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
  <script src="js/lib/d3/d3.js"></script>
  <script src="js/lib/d3/d3.layout.cloud.js"></script>
  <script src="js/d3.wordcloud.js"></script>
</head>
<style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  background-color: #555555; 
  
}
 #imaginary_container{
    margin-top:0%; /* Don't copy this */
}

.form-control:focus {
  background-color: gray;
  border-color:black;
  color:white;

}
</style>
<body style="background-color:#b3b3b3">

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <!-- Brand/logo -->
  <a class="navbar-brand" href="#">
    <img src="logo.png" alt="logo" style="width:90px;">
  </a>
  
  <!-- Links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">Home</a>
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
    <h6>Search</h6>
    <div class="row">
        <div class="col-md-6">
		<div id="imaginary_container">
		<form method="POST" action="">
                <div class="input-group">
                    <input type="text" name="requete" id="search" class="form-control">
                    <span class="input-group-btn">
                        <input style="background-color:black; color:white;" class="btn btn-block" type="submit" name="commit" value="Search"  data-disable-with="Search">
                     </span>
                </div>
            </form>
        </div>
       
			
			
			
			
				<?php


				if(isset($_POST['requete']))
				{
					$sql = "select document.id as id,document.document as doc,
								document.titre as titre,
								document.description as descrip,
								mot_document.poids as poid
								from mot_document join document
								on mot_document.id_document = document.id
								join  mot on
								mot_document.id_mot = mot.id  where mot.mot = '$_POST[requete]' ";
					$result = mysqli_query($bdd, $sql);


					echo " &nbsp;&nbsp;&nbsp;resultats pour <b> $_POST[requete] </b>...<br><br>";
				?>


						  
				  

				<?php

					if (mysqli_num_rows($result) > 0) {
						
						while($row = mysqli_fetch_assoc($result)) {
						echo "<h3 style='color:blue;'>" . $row["titre"]. "</h3>";
						echo "<font color='green'>" . $row["doc"]. "</font><br>";
						$id = $row['id'];
						echo "" . $row["descrip"]. "<br>";
						echo "<font color='#b30086'>Poids = " . $row["poid"]. "</font><br>";
						echo "<button class='button' id=".$id." value=".$id.">Cliquer ici pour afficher le nuage de mots-cles</button>";
						$id = $row['id'];
						?>

					
						<?php
						
						}
					}
				}

				?>		    
				

				 
			
			
			
			
        </div>
		
		<div class="col-sm-6">
		
			<script type="text/javascript">
					$( ".button" ).click(function () {  
						var id = $(this).attr('id');
						$.getJSON("getDocument.php?q="+id,  function(data){
							d3.wordcloud()
							  .size([550, 300])
							  .selector('#wordcloud')
							  .words(data)
							  .start();	  
						  });
						});
			</script>
		
			<div id="wordcloud">
			</div>
		
		</div>
	</div>
</div>

<br><br><br>

</body>
</html>
