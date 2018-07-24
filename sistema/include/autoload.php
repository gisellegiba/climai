<?php
//para não ter que chamar uma por uma classe utilizamos a função autoload
function __autoload($classe){
	require("classes/".$classe.".php");
}
?>