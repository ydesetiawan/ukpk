<?php
class Database {
	private static $dbName = 'mydatabase';
	private static $dbHost = 'db';
	private static $dbUsername = 'myuser';
	private static $dbUserPassword = 'mypassword';

	private static $cont = null;

	public function __construct() {
		exit('Fungsi ini tidak diperbolehkan');
	}

	public static function connect() {
		if (null == self::$cont) {
			try {
				self::$cont = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
			} catch(PDOException $e) {
				die($e -> getMessage());

			}
		}
		return self::$cont;
	}

	public static function disconnect() {
		self::$cont = null;
	}

}

?>
