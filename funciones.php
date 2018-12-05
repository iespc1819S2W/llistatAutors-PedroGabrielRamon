<?php
function creacionSelect($mysqli,$query,$name,$defecto,$value,$visual,$form,$null=true){
$cadena="<select form='$form' name='".$name."'  >";
if ($cursor=$mysqli->query($query)OR die($query)) {
	if($null===true){
		$cadena=$cadena."<option form='$form' value=''>"."Elige una opcion"."</option>";
	}
	while ($row = $cursor->fetch_assoc()) {
		if($row[$value]===$defecto){
			$cadena=$cadena."<option   value='".$row[$value]."'selected>".$row[$visual]."</option>";
		} else{
			$cadena=$cadena."<option  value='".$row[$value]."'>".$row[$visual]."</option>";
		}
		
		
 };
$cadena=$cadena."</select>";
 }
 return $cadena;
}
?>
