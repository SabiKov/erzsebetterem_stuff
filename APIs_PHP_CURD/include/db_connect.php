<?php

// -----------------------------------------------------------------------------
// This function is common to all the database operations.
// It makes a connection to the database given its name
// and returns a link to the database.
// -----------------------------------------------------------------------------
	function dbConnection() {
		$connection = mysqli_connect("localhost","erzsebet_akos","19Slaveke78","erzsebet_terem");

		return $connection;

	}
?>
