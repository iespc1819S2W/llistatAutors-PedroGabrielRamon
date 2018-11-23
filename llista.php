<?php
$mysqli = new mysqli("localhost", "biblioteca", "1", "biblioteca");
$mysqli->set_charset("utf8");
$ordre="asc";
$ordenat="ID_AUT";

if(isset($_POST["ordre"])){
	$ordre=$_POST["ordre"];
}

if(isset($_POST["ordenat"])){
	$ordenat=$_POST["ordenat"];
}

if(isset($_POST["id_aut_asc"])){
$ordenat="ID_AUT";
$ordre="asc";
};
if(isset($_POST["id_aut_desc"])){
$ordre="desc";
$ordenat="ID_AUT";
};
if(isset($_POST["nom_aut_asc"])){
$ordre="asc";
$ordenat="NOM_AUT";
};
if(isset($_POST["nom_aut_desc"])){
$ordenat="NOM_AUT";
$ordre="desc";
};
$pagina=1;
$valorinicial=0;
$valorultim=20;
$cantidad="";
$paginaTotales="";

	$queryUltimo="select count(*) as 'cantidad' from AUTORS";
	if ($cursor=$mysqli->query($queryUltimo)) {
	while ($row = $cursor->fetch_assoc()) {
		$cantidad=$row['cantidad'];
		

};
$paginaTotales=ceil($cantidad/20);
$paginaTotales-=1;
 $cursor->free();

};

	if(isset($_POST["pagina"])){
		$pagina=$_POST["pagina"];
		if($pagina>1){
		$valorinicial=20*$pagina;
	} else {
		$valorinicial=0;
	}
	}

if(isset($_POST["ultimo"])){
$valorinicial=$paginaTotales*20;
$pagina=$paginaTotales;	
}
if(isset($_POST["primero"])){
$valorinicial=0;
$pagina=1;
}
if(isset($_POST["siguiente"])){
	if($pagina!=$paginaTotales){
		$pagina++;
	$valorinicial=20*$pagina;
	
	};
};
if(isset($_POST["atras"])){
	if($pagina>1){
		$pagina--;
	$valorinicial=20*$pagina;
} else {
	$pagina=1;
	$valorinicial=0;
}};

 ?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="llista.css"/>
<title></title>
</head>
<body>
<form action='llista.php' METHOD='POST'>
<div>
	<div>
	<input type="hidden" name="ordenat" value="<?=$ordenat?>">
	<input type="hidden" name="ordre" value="<?=$ordre?>">
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


// order by ID_AUT desc                 

$query="select * from AUTORS order by ".$ordenat." ".$ordre." limit ".$valorinicial.",".$valorultim;


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
echo "<span>".$pagina."/".$paginaTotales."</span>";
echo "</body>";
echo "</html>";
?>