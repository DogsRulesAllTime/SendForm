<?php


//подключение к бд
$connect = mysqli_connect("localhost", "root", "", "baza");
if ($connect == false) {
	echo "не удалось установить соединение с базой";
	//die();
	}else {
	echo "<H3>"."база подключена"."</H3>";
	}

?>