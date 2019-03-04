<?php

namespace App\Entities;

use Illuminate\Database\Connectors\MySqlConnector;
use Illuminate\Database\MySqlConnection;

class NcuccOffdutyConnector extends MySqlConnector
{
	/**
	 * Establish a database connection.
	 *
	 * @param  array  $config
	 * @return \PDO
	 */
	public function connect(array $config)
	{
		$dsn = $this->getDsn($config);

		$options = $this->getOptions($config);
		
		$connection = $this->createConnection($dsn, $config, $options);

		if (isset($config['unix_socket']))
		{
			$connection->exec("use {$config['database']};");
		}

		if (isset($config['strict']) && $config['strict'])
		{
			$connection->prepare("set session sql_mode='STRICT_ALL_TABLES'")->execute();
		}

		return $connection;
	}
}

class NcuccOffduty extends BaseEntity
{
	protected $connection = 'NcuccOffdutyDB';
	protected $table = 'ISP_email';
	protected $primaryKey = 'sid';
	protected $fillable = ['trans_flag'];

	/**
	 * Resolve a connection instance.
	 *
	 * @param  string  $connection
	 * @return \Illuminate\Database\Connection
	 */
	public static function resolveConnection($connection = null)
	{

		static::$resolver->extend('NcuccOffdutyDB', function($config, $name)
		{
			$connector = new NcuccOffdutyConnector();
			$pdoConnection = $connector->connect($config);

			return new MySqlConnection($pdoConnection, $config['database'], $config['prefix'], $config);
		});

		return static::$resolver->connection($connection);
	}
}

?>