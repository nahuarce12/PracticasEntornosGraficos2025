<?php

declare(strict_types=1);

/**
 * Configuración de la base de datos
 */
class DatabaseConfig
{
  public const HOST = 'localhost';
  public const PORT = 3308;
  public const USERNAME = 'root';
  public const PASSWORD = '';
  public const DATABASE = 'capitales';
  public const CHARSET = 'utf8mb4';
}

/**
 * Clase para manejo de la conexión MySQLi
 */
class Database
{
  private ?mysqli $connection = null;

  /**
   * Obtener conexión a la base de datos
   */
  public function getConnection(): mysqli
  {
    if ($this->connection === null) {
      $this->connection = new mysqli(
        DatabaseConfig::HOST,
        DatabaseConfig::USERNAME,
        DatabaseConfig::PASSWORD,
        DatabaseConfig::DATABASE,
        DatabaseConfig::PORT
      );

      if ($this->connection->connect_error) {
        throw new Exception(
          'Error de conexión a la base de datos: ' .
            $this->connection->connect_error .
            ' (Host: ' . DatabaseConfig::HOST .
            ':' . DatabaseConfig::PORT . ')'
        );
      }

      $this->connection->set_charset(DatabaseConfig::CHARSET);
    }

    return $this->connection;
  }

  /**
   * Cerrar conexión
   */
  public function closeConnection(): void
  {
    if ($this->connection !== null) {
      $this->connection->close();
      $this->connection = null;
    }
  }

  /**
   * Escapar string para prevenir SQL injection
   */
  public function escapeString(string $string): string
  {
    return $this->getConnection()->real_escape_string($string);
  }

  /**
   * Destructor para cerrar conexión automáticamente
   */
  public function __destruct()
  {
    $this->closeConnection();
  }
}
