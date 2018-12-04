<?php
$mysqli = new mysqli("localhost", "biblioteca", "1", "biblioteca");
$mysqli->set_charset("utf8");
require_once("funciones.php");
/* PAGINA */
if(isset($_POST["pagina"])){
	$pagina=$_POST["pagina"];
} else {
	$pagina=1;
}
$quantitat=20;
/* FIN DE PAGINA */
/* Comprobacion de ordenacion */
if(isset($_POST["ordre"])&&isset($_POST["quien"])){
	$ordre=$_POST["ordre"];
	$quien=$_POST["quien"];
} else {
	$ordre="asc";
$quien="ID_AUT";
}
/* FIN DE COMPROBACION DE ORDENACION */

/* Ordenacion */
if(isset($_POST["id_aut_asc"])){
$ordre="asc";
$quien="ID_AUT";
echo "Ordenado por: ID_AUT ASC<br>";
};
if(isset($_POST["id_aut_desc"])){
$ordre="desc";
$quien="ID_AUT";
echo "Ordenado por: ID_AUT DESC<br>";
};
if(isset($_POST["nom_aut_asc"])){
$ordre="asc";
$quien="NOM_AUT";
echo "Ordenado por: NOM_AUT ASC<br>";
};
if(isset($_POST["nom_aut_desc"])){
$ordre="desc";
$quien="NOM_AUT";
echo "Ordenado por: NOM_AUT DESC <br>";
};
/* FIN DE ORDENACION */
/* FILTRO */
if(isset($_POST["filtro"])){
	$filtro=$mysqli->real_escape_string($_POST["filtro"]);
} else {
	$filtro="";
}
/* FIN DEL FILTRO */
/* COMPROBAR BOTON */
$idaut="";
if(isset($_POST["editar"])){
	$idaut=$_POST["editar"];
}
/* COMPROBACION DEL BOTON CONFIRMAR */
if(isset($_POST["modificacion"])){
	$modificacion=$_POST["modificacion"];
	$nomedit=$mysqli->real_escape_string($_POST["nomedit"]);
	$query="update AUTORS SET NOM_AUT = '$nomedit' where ID_AUT=$modificacion   ";
	$cursor=$mysqli->query($query)OR die($query);
}
/* FIN COMPROBACION DEL BOTON CONFIRMAR */
/* FIN DEL COMPROBAR BOTON*/

/* INICIO AÑADIR AUTOR */
if(isset($_POST["inputnouautor"])){
	if(isset($_POST["nou"])){
		$nouautor=$mysqli->real_escape_string($_POST["inputnouautor"]);

		$nouautor=trim($nouautor," ");
		if(strlen($nouautor)!=0){
			$query='INSERT INTO AUTORS(ID_AUT, NOM_AUT) VALUES ((SELECT MAX(ID_AUT)+1 FROM AUTORS as max),"'.$nouautor.'")';
			$cursor=$mysqli->query($query)OR die($query);
		}
	}
	
}
/* FIN AÑADIR AUTOR */
/* BORRAR AUTOR */
if(isset($_POST["borrar"])){
	$borrar=$_POST["borrar"];
	$query="delete from AUTORS where ID_AUT=$borrar";
	$cursor=$mysqli->query($query)OR die($query);
}
/* FIN BORRAR AUTOR*/

/* CONTAR TODAS LAS PAGINAS */
$query="select count(*) as numero from AUTORS where ID_AUT like '".$filtro."' or NOM_AUT like '%".$filtro."%' or FK_NACIONALITAT like '".$filtro."'";
 if ($cursor=$mysqli->query($query)OR die($query)){
 while ($row=$cursor->fetch_assoc()) {
  $filas=$row['numero'];
  $paginas=ceil($filas/$quantitat);
 }
 }
 /* Buscador */
 if (isset($_POST["buscar"])){
 	$pagina=1;
 }
 /* FIN BUSCADOR */
/* Paginacion */
 if (isset($_POST["primero"])) {
  $pagina=1;   
 }
 if (isset($_POST["ultimo"])) {
  $pagina=$paginas;   
 }
 if (isset($_POST["atras"])) {
  if ($pagina>1) {   
   $pagina--;   
  }
 }
 if (isset($_POST["siguiente"])) {
  if ($pagina<$paginas) {   
   $pagina++;  
  }
 } 
/* FIN DE PAGINACION */

 /* Calculo de paginas */

  $fila=($pagina-1)*$quantitat;
  $query="select ID_AUT,NOM_AUT,FK_NACIONALITAT from AUTORS where ID_AUT like '".$filtro."' or NOM_AUT like '%".$filtro."%' or FK_NACIONALITAT like '".$filtro."' order by ".$quien." ".$ordre." limit ".$fila.",".$quantitat;
  /* FIN DEL CALCULO */
  /* QUERY PARA SELECT */
  $querySelect= "SELECT * FROM NACIONALITATS";
  /*FIN QUERY PARA SELECT */
?>
<!DOCTYPE html>
<html>
<head>
<title>Llista</title>
<link rel="stylesheet" href="llista.css"/>
</head>
<body>
<form id="form" action='llista.php' METHOD='POST'>
<div>
	<div>
	
	<input type="hidden" name="pagina" value="<?=$pagina?>">
	<input type="hidden" name="ordre" value="<?=$ordre?>">
	<input type="hidden" name="quien" value="<?=$quien?>">
	</div>
	<div>
	<label for="filtro">Nom de Autor o ID</label><br>
	<input type="text" name="filtro" value="<?=$filtro?>"><button type=input name="buscar">Cercar</button><br>
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
	<button name="atras">❮</a>
	<button name="siguiente">❯</a>
	<button name="ultimo">&raquo;</a>
</div>
 </form>
<?php
echo "<table>";
		echo "<tr>";
 echo "<td>ID Autor</td><td>Nom Autor</td><td>Nacionalitat</td>"; 
		echo "</tr>";
if ($cursor=$mysqli->query($query)OR die($query)) {
	while ($row = $cursor->fetch_assoc()) {
		echo "<tr>";
		if($idaut==$row["ID_AUT"]){
			 echo "<td>".$row["ID_AUT"]."</td>
			 <td><input form='form' type='text' name='nomedit' value='{$row["NOM_AUT"]}'></td>
			 <td>".creacionSelect($mysqli,$querySelect,'nacionalitat','FK_NACIONALITAT','FK_NACIONALITAT','form')."</td>
			 <td><button form='form' type='submit' name='cancelar'>Cancelar</button></td><td><button form='form' name='modificacion' value=".$row['ID_AUT'].">Confirmar</button></td>";
		} else {

	echo "<td>".$row["ID_AUT"].'</td><td>'. $row["NOM_AUT"]."</td><td>".$row['FK_NACIONALITAT']."</td><td><button name='editar' form='form' type='submit' value=".$row["ID_AUT"].">Editar</a></td><td><button form='form' type='submit' name='borrar' value=".$row["ID_AUT"].">Borrar</a></td>"; 
 echo "</tr>";
 	}
 };
 $cursor->free();
 }
echo "</table>";
echo "<br><label for='nouautor'>Afegir nou Atutor</label><br>";
echo "<input form='form' type='text' name='inputnouautor'></td><button form='form' type=input name='nou'>Añadir</button><br>";
echo "$pagina/$paginas";
$mysqli->close();
echo "</body>";
echo "</html>";
?> 