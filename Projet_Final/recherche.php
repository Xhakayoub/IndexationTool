<?php

// Connexion base de donnée 
$bdd = mysqli_connect('localhost', 'root', '', 'tiw');
		


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title> AI-Search </title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>
    <script src="js/lib/d3/d3.js"></script>
    <script src="js/lib/d3/d3.layout.cloud.js"></script>
    <script src="js/d3.wordcloud.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#">Indexation</a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="index.php">Home</a></li>
      <li class="active"><a href="rechercher1.html">Search</a></li>

    </ul>
  </div>
</nav>
<br/><br/><br/>

<div class="container">

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


	echo "<h1>Les résultats pour <i> $_POST[requete] </i></h1>";
?>


          
  <table class="table table-striped">
    <thead>
      <tr>
        <th>Document</th>
        <th>Titre</th>
        <th>Poids</th>
		<th>show</th>
      </tr>
    </thead>
    <tbody>

<?php

	if (mysqli_num_rows($result) > 0) {
		
		while($row = mysqli_fetch_assoc($result)) {
		$i = 1;	
		echo "<tr>";
        echo "<td>" . $row["doc"]. "</td>";
        echo "<td>" . $row["titre"]. "</td>";
        echo "<td>" . $row["poid"]. "</td>";
		echo "<td><button onclick='hidesAll()'>+</button></td>";
		
		echo "</tr>";
		$id = $row['id'];
		?>
		<script type="text/javascript">
	
	
	
    $(function () {    

      $.getJSON("getDocument.php?q=<?php echo $id ?>",

          function(data){

            d3.wordcloud()
              .size([800, 400])
              .selector('#wordcloud')
              .words(data)
              .start();
                  
          });
      
    });
	
    </script>
	
	<tr><td colspan="4" align="center" style="display:none;" class="<?php echo $i ?>" id ="wordcloud">
	
	</td></tr>
		<?php
		$i++;
		}
	}
}

?>


      
      
    </tbody>
  </table>

  
  

</div>
<script>


function hidesAll(){
        
		
		
        $("td#wordcloud").toggle(1000);
		
    }
</script>
</body>
</html>
<br/>
<br/>