<?php
function creacionSelect($mysqli,$query,$name,$value,$visual,$form){

echo "<select form='$form'>";
if ($cursor=$mysqli->query($query)OR die($query)) {
	while ($row = $cursor->fetch_assoc()) {
		 echo "<option value='".$row['$value']."' name='".$name."'>".$row['$visual']."</option>";
		
 };
 echo "</select>";
 }
}
?>
