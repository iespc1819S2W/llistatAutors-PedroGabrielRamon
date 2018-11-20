
<!DOCTYPE html>
<html>
<head>
<title></title>
<style>
*{text-align: center; margin:auto; }
table{margin:auto;border:solid 1px;}
</style>
</head>
<body>
<form action='llista.php' METHOD='POST'>
<div>
	<div>
	<button name='id_aut_asc'>Codi ascendent</button>
	<button name='id_aut_desc'>Codi descendent</button>
	</div>
	<div>
	<button name='nom_aut_asc'>Nom ascendent</button>
	<button name='nom_aut_desc'>Nom descendent</button>
	</div>
</div>

</form>
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
$query="select * from AUTORS ".$ordenat." limit 20";
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

}
echo "</table>";
$mysqli->close();
echo "</body>";
echo "</html>";
?>