<?php
/**
 * @author  Halogy Dev Team
 * @package Halogy\Installer
 *
 */
class Database {

	/**
	 * Function to create the database.
	 *
	 * @return bool
	 */
	function create_database($data)
	{
		/** @var object Connect to the database using mysqli */
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],'');

		/** check for errors */
		if(mysqli_connect_errno())
			return false;

		/** prepare sql statement */
		$mysqli->query("CREATE DATABASE IF NOT EXISTS ".$data['database']);

		/** close the connection */
		$mysqli->close();

		return true;
	}

	/**
	 * Function to create the tables and fill with default data.
	 *
	 * @return bool
	 */
	function create_tables($data)
	{
		/** @var object Connect to the database */
		$mysqli = new mysqli($data['hostname'],$data['username'],$data['password'],$data['database']);

		/** check for errors */
		if(mysqli_connect_errno())
			return false;

		/** @var string Open the SQL file */
		$query = file_get_contents('assets/install.sql');

		/** execute a multi query */
		$mysqli->multi_query($query);

		/** close the connection */
		$mysqli->close();

		return true;
	}
}