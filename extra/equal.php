<?php

$var1 = $_GET['number_1'];
$var2 = $_GET['number_2'];

if(isset($_GET['submit'])){
	if($var1 == $var2){
		echo $var1." is equal to ".$var2; 
	}else{
		echo $var1." is not equal to ".$var2;
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Equals?</title>
</head>
<body>
	<form method="GET">
		<input type="text" name="number_1" />
		<input type="text" name="number_2" />
		<input type="submit" name="submit" value="Submit" />
	</form>
</body>
</html>