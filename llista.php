<?php
$mysqli = new mysqli("localhost", "biblioteca", "1", "biblioteca");
$mysqli->set_charset("utf8");
$ordenat="order by ID_AUT asc";
if(isset($_POST["id_aut_asc"])){
$ordenat="order by ID_AUT asc";
};
if(isset($_POST["id_aut_desc"])){
$ordenat="order by ID_AUT desc";
};
if(isset($_POST["nom_aut_asc"])){
$ordenat="order by NOM_AUT asc";
};
if(isset($_POST["nom_aut_desc"])){
$ordenat="order by NOM_AUT desc";
};
$pagina=1;
$valorinicial=0;
$valorultim=20;
$cantidad="";
$paginaTotales="";
	if(isset($_POST["pagina"])){
		$pagina=$_POST["pagina"];
		$valorinicial=20*$pagina;
	}

if(isset($_POST["ultimo"])){
	$queryUltimo="select count(*) as 'cantidad' from AUTORS";
	if ($cursor=$mysqli->query($queryUltimo)) {
	while ($row = $cursor->fetch_assoc()) {
		$cantidad=$row['cantidad'];
		

};
$paginaTotales=ceil($cantidad/20);
$paginaTotales-=1;
 $cursor->free();

};
$valorinicial=$paginaTotales*20;
$pagina=$paginaTotales;	
}
if(isset($_POST["primero"])){
$valorinicial=0;
}
if(isset($_POST["siguiente"])){
	$valorinicial=20*$pagina;
	$pagina++;
	
	
}
if(isset($_POST["atras"])){
	$valorinicial=20*$pagina;
	$pagina--;
}

 ?>
<!DOCTYPE html>
<html>
<head>
<title></title>
<style>
/* ceil(50/100)*/
*{text-align: center; margin:auto; }
table{margin:auto;border:solid 1px;}
.pagination button {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 0 4px;
}
.pagination {
    display: inline-block;
}
button:hover{
	background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
}
</style>
</head>
<body>
<form action='llista.php' METHOD='POST'>
<div>
	<div>
	<input type="hidden" name="pagina" value="<?=$pagina?>">
	<button name='id_aut_asc'>Codi ascendent</button>
	<button name='id_aut_desc'>Codi descendent</button>
	</div>
	<div>
	<button name='nom_aut_asc'>Nom ascendent</button>
	<button name='nom_aut_desc'>Nom descendent</button>
	</div>
</div>
<div class="pagination">
<button name="primero">&laquo;</a>
<button  name="atras">❮</a>
<button  name="siguiente">❯</a>
<button  name="ultimo">&raquo;</a>
</div>
</form>
<?php




$query="select * from AUTORS ".$ordenat." limit ".$valorinicial.",".$valorultim;


echo "<table>";
		echo "<tr>";
 echo "<td>ID Autor</td><td>Nom Autor</td>"; 
		echo "</tr>";
if ($cursor=$mysqli->query($query)) {
	while ($row = $cursor->fetch_assoc()) {
		echo "<tr>";
 echo "<td>".$row["ID_AUT"].'</td><td>'. $row["NOM_AUT"]."</td>"; 
 echo "</tr>";

};
 $cursor->free();

};
echo "</table>";

$mysqli->close();
echo "</body>";
echo "</html>";
?>