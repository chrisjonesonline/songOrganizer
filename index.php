<!DOCTYPE html>
<html>
<head>
<title>songOrganizer</title>
<link href="assets/css/style.css" media="screen,projection" rel="stylesheet" type="text/css">
</head>
<body>

<h1>Song Organizer</h1><hr />

<?php
//TODO: 1
if (isset($_GET['action'])) {
	if ((file_exists("assets/txt/songs.txt")) && (filesize("assets/txt/songs.txt") != 0)) {
		$SongArray = file("assets/txt/songs.txt");
			
			switch ($_GET['action']) {
			//TODO: 2
			case 'Remove Duplicates':
				$SongArray = array_unique($SongArray);
				$SongArray = array_values($SongArray);
				break;
			case 'Sort Ascending':
				sort($SongArray);
				break;
			case 'Shuffle':
				shuffle($SongArray);
				break;
 } //End of the switch statement
	//TODO: 3
	if (count($SongArray)>0) {
		$NewSongs = implode($SongArray);
	$SongStore = fopen("assets/txt/songs.txt","wb");
		if ($SongStore === false) {
			echo "There was an error updating the song file\n";
		} else {
			fwrite($SongStore, $NewSongs);
			fclose($SongStore);
		}
	} else
		unlink("assets/txt/songs.txt");
	}
}

//TODO: 4
if (isset($_POST['submit']) && ($_POST['SongName']) != '') /** Check if empty **/ {
	$SongToAdd = stripslashes($_POST['SongName']) . "\n";
	$ExistingSongs = array();
	
	if (file_exists("assets/txt/songs.txt") && filesize("assets/txt/songs.txt") > 0) {
		$ExistingSongs = file("assets/txt/songs.txt");
	}
//TODO: 5
	if (in_array($SongToAdd, $ExistingSongs)) {
		echo "<p>The song you entered already exists!<br />\n";
		echo "Your song was not added to the list.</p>";
	} /** TODO: 6 **/ else {
		$SongFile = fopen("assets/txt/songs.txt", "ab");
		if ($SongFile === false)
			echo "There was an error saving your message!\n";
		else {
			fwrite($SongFile, $SongToAdd);
			fclose($SongFile);
			echo "Your song has been added to the list.\n";
		}
	}
}
//TODO: 7
if ((!file_exists("assets/txt/songs.txt")) || (filesize("assets/txt/songs.txt") == 0)) {
	echo "<p>There are no songs in the list.</p>\n";
} else {
	$SongArray = file("assets/txt/songs.txt");
		echo "<table border=\"1\" width=\"100%\"style=\"background-color:lightgray\">\n";
		foreach ($SongArray as $Song) {
			echo "<tr>\n";
			echo "<td>" . htmlentities($Song) . "</td>";
			echo "</tr>\n";
		} echo "</table>\n";
}

?>

<p>
<a href="index.php?action=Sort%20Ascending">Sort Song List</a><br />
<a href="index.php?action=Remove%20Duplicates">Remove Duplicate Songs</a><br />
<a href="index.php?action=Shuffle">Randomize Song list</a><br />
</p>

<form action="index.php" method="post">
<p>Add a New Song</p>
<p>Song Name: <input type="text" name="SongName" autocomplete="off" /></p>
<p><input type="submit" name="submit" value="Add Song to List" /> <input type="reset" name="reset" value="Reset Song Name" /></p>
</form>

</body>
</html>