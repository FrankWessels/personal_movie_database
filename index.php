<?php
//Some defaults
$order = "Title";
$genre = "";
//To be safe, make array with all possibilities
$orders = array("Title", "Title DESC", "imdbRating", "imdbRating DESC");
$genres = array("", "Action", "Adventure", "Biography", "Comedy", "Crime", "Drama", "Fantasy", "History", "Horror", "Romance", "Sci-Fi", "Thriller", "War", "Western");
//Get variables
if (in_array($_GET["o"], $orders)) {
	$order=$_GET["o"];
}
if (in_array($_GET["g"], $genres)) {
	$genre=$_GET["g"];
}
//Connect to the db
$servername = "lservername";
$username = "username";
$password = "pass";
$dbname = "dbname";
$table = 'movie_data';
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//Make query
$sql = "SELECT * FROM ".$table." WHERE Genre LIKE '%".$genre."%' ORDER BY ".$order;
$result = mysqli_query($conn, $sql);
?>

<!doctype html>

<html lang="en">
	<head>
		<meta charset="utf-8">

		<title>Movie Database</title>
		<meta name="description" content="Movie Database">
		<meta name="author" content="Frank Wessels">

		<link rel="stylesheet" href="style.css?v=1.0">

	</head>

	<body LINK="#000000" VLINK="#000000" ALINK="#000000" style=text-decoration:none;>
		<div id="wrapper">	
			<div id="header">
				<h2>Movie database</h2>
			</div><br>
			<div id="menu">
				<div id="m1">
					<a href="?o=Title&g=<?php echo $genre; ?>">Title</a>
				</div>
				<div id="m2">
					<?php
						$gleft = floor(sizeof($genres)/2);
						$gright = sizeof($genres)-$gleft-1;

						echo '<a href="?o='.$order.'&g='.$genres[0].'">Genre</a><br>';
						for ($i = 1; $i < $gleft+1; $i++) {
							echo '<a href="?o='.$order.'&g='.$genres[$i].'">&#8226;</a>';
						}
						for ($i = $gleft+1; $i < $gleft+1+$gright; $i++) {
							echo '<a href="?o='.$order.'&g='.$genres[$i].'">&#8226;</a>';
						}
					?>
				</div>
				<div id="m3">
					<a href="?o=imdbRating DESC&g=<?php echo $genre; ?>">Score</a>
				</div>
				
				
			</div><br>	
			<?php
			//For styling purposes
			$n = 0;
			$colors = array("#bbbbff", "#7777ff", "#9999ff", "#ddddff");
			$colors = array("#ffbbbb", "#ff7777", "#ff9999", "#ffdddd");
			$colors = array("#bbbbbb", "#777777", "#999999", "#dddddd", "#aaaaaa", "#666666", "#888888", "#cccccc");
			$ncolors = sizeof($colors);
			$color = $colors[0];
			if (mysqli_num_rows($result) > 0) {
			
				while($row = mysqli_fetch_assoc($result)) {
					$color = $colors[$n % $ncolors];
					$n = $n + 1;
					echo '<div class="r" style=background-color:'.$color.'>';
						echo '<a href="';
						echo htmlentities($row["path"]);
						echo '"><div class="play">';
						echo '</div>';
						echo '</a>';
						echo '<div class="title">';
							echo '<nobr>'.htmlentities($row["Title"]).'</nobr>';
						echo '</div>';
						echo '<div class="genre">';
							echo htmlentities($row["Genre"]);
						echo '</div>';
						echo '<div class="score">';
							echo htmlentities($row["imdbRating"]);
						echo '</div>';
						echo '<div class="poster" style=background-image:url("'.$row["Poster"].'")>';

						echo '</div>';
						echo '<div class="info">';
							echo '<table cellspacing="2" border="0" style="width:100%">';
							echo '<tr><td valign="top"><b>Plot: </b></td><td>'.htmlentities($row["Plot"]).'</td></tr>';
							echo '<tr><td><b>Director: </b></td><td>'.htmlentities($row["Director"]).'</td></tr>';
							echo '<tr><td><b>Actors: </b></td><td>'.htmlentities($row["Actors"]).'</td></tr>';
							echo '<tr><td><b>Released: </b></td><td>'.htmlentities($row["Released"]).'</td></tr>';
							echo '</table>';
						echo '</div>';
					echo '</div><br>';
				}
			}	
			?>

		</div>
			<br><br><br><br><br><br><br><br><br><br>
	</body>
</html>
