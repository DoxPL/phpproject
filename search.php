<?php
require_once "mysql.php";
include_once "valid.php";
?>
<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv = "Content-Type" content = "text/html; charset = utf-8">
		<title>Katalog samochodów</title>		
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link rel = "stylesheet" type = "text/css" href = "css/style.css">	
		<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Cabin+Condensed" rel="stylesheet">
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script> 
			$(document).ready(function(){
				$('.menu_ico').click(function(){
					$('div#menu').show();
					$('.mlink').show();
					$('div#mobile_bar').hide();
				});
				$('.more').click(function(){
					$('.less_info').hide();
					$('.more_info').show();		
					$('.more').hide();
					$('.less').show();
				});
				$('.less').click(function(){
					$('.more_info').hide();
					$('.less_info').show();		
					$('.less').hide();
					$('.more').show();
				});
			});

		</script>
	</head>
	<body>

			<div id = "header">
				<img src = "imgs/logo.png" alt = "Katalog samochodów" class = "logo">
				
			</div>		
		
			<div id = "menu">
					<a href = "index.php" class = "mlink">Strona główna</a> |
					<a href = "cat.php" class = "mlink">Przeglądaj katalog</a> |
					<a href = "add.php" class = "mlink">Dodaj samochód</a> |
					<a href = "search.php" class = "mlink">Szukaj pojazdu</a> |
		
			</div>				
			<div id = "mobile_bar"> 
				<img src = "imgs/menu.png" class = "menu_ico">
			</div>
			<div class = "container">	
			<div id = "left">
			
				<h1 class = "htext">Wyszukiwarka samochodów</h1>
				
				<?php
					$comp = isset($_GET['comp']) ? "AND companies.name='$_GET[comp]'" : "";
					if(!isset($_GET['query']))
					{
					?>
					<div id = "car">
					<form action = "search.php" method = "get">
						<label>Słowo kluczowe</label>
						<p>
						<input type="text" class="form-control" placeholder="Tekst do znalezienia" name = "query">
						</p>
						<label>Szukaj tylko według wybranych firm</label>
						<p>
						<select multiple class="form-control" name = "comp">
						<?php
							$mysql->connect();
							$sql = "SELECT * FROM companies ORDER BY name ASC";
							$result = $mysql->conn->query($sql);
							while($row = $result->fetch_array())
							{
								echo "<option>".$row['name']."</option>";
							}
							$mysql->cls();						
						?>
						</select>
						</p>
						<p><input type="submit" class="btn btn-success" value = "Szukaj samochodu"></p>
					</form>
					</div>
				<?php
					}
					else
					{
						$mysql->connect();
						$query = trim(strip_tags(addslashes($_GET['query'])));
						if(!empty($query))
						{
							$mysql->conn->query("SET NAMES UTF8");		
							$sql = "SELECT * FROM `companies`, `cars` WHERE (cars.model LIKE '%$query%' OR cars.descr LIKE '%$query%') AND cars.comp=companies.c_id $comp ORDER BY name ASC";
							$result = $mysql->conn->query($sql);
							while($row = $result->fetch_array())
							{
								echo "<div id = 'car'>";
								echo "<h3>".$row['name']."</h3>";
								echo "<h4>".$row['model']."</h4>";
								echo "<h4>".$row['descr']."</h4>";
								echo "<img src = '$row[img]' class = 'car_img_min'/>";
								echo "</div>";
							}
							$mysql->cls();	
						}		
						else
						{
							echo "<div id = 'car'>Brak podanej frazy do wyszukania.</div>";
						}
					}
				?>
				
			</div>
			
			<div id = "right">
				<h1 class = "htext">Lista firm</h1>
					<div id = "comp_list">
						<?php
						$mysql->connect();
						$sql = "SELECT * FROM companies ORDER BY name ASC";
						$result = $mysql->conn->query($sql);
						while ($row = $result->fetch_array())
						{
							echo "<h4><a href='cat.php?company=$row[name]'>".$row['name']."</a></h4>";
						}
						$mysql->cls();
						?>
					</div>
				
			</div>
		</div>
		<div id = "footer">
			Copyright &copy; 2016-2017 Dominik Galoch <br />
			Projekt strony internetowej wykonany na ćwiczenia z przedmiotu SPI
		</div>			
			
	</body>
</html>
	