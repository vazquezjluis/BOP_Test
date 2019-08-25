<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['dsn']      The full DSN string describe a connection to the database.
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database driver. e.g.: mysqli.
|			Currently supported:
|				 cubrid, ibase, mssql, mysql, mysqli, oci8,
|				 odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Query Builder class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7
|				 (and in table creation queries made with DB Forge).
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['encrypt']  Whether or not to use an encrypted connection.
|
|			'mysql' (deprecated), 'sqlsrv' and 'pdo/sqlsrv' drivers accept TRUE/FALSE
|			'mysqli' and 'pdo/mysql' drivers accept an array with the following options:
|
|				'ssl_key'    - Path to the private key file
|				'ssl_cert'   - Path to the public key certificate file
|				'ssl_ca'     - Path to the certificate authority file
|				'ssl_capath' - Path to a directory containing trusted CA certificates in PEM format
|				'ssl_cipher' - List of *allowed* ciphers to be used for the encryption, separated by colons (':')
|				'ssl_verify' - TRUE/FALSE; Whether verify the server certificate or not ('mysqli' only)
|
|	['compress'] Whether or not to use client compression (MySQL only)
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|	['ssl_options']	Used to set various SSL options that can be used when making SSL connections.
|	['failover'] array - A array with 0 or more data for connections if the main should fail.
|	['save_queries'] TRUE/FALSE - Whether to "save" all executed queries.
| 				NOTE: Disabling this will also effectively disable both
| 				$this->db->last_query() and profiling of DB queries.
| 				When you run a query, with this setting set to TRUE (default),
| 				CodeIgniter will store the SQL statement for debugging purposes.
| 				However, this may cause high memory usage, especially if you run
| 				a lot of SQL queries ... disable this to avoid that problem.
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $query_builder variables lets you determine whether or not to load
| the query builder class.
*/

/*
| -------------------------------------------------- -----------------
| CONFIGURACIÓN DE CONECTIVIDAD DE BASE DE DATOS
| -------------------------------------------------- -----------------
| Este archivo contendrá la configuración necesaria para acceder a su base de datos.
|
| Para obtener instrucciones completas, consulte la 'Conexión de la base de datos'
| página de la Guía del usuario.
|
| -------------------------------------------------- -----------------
| EXPLICACIÓN DE VARIABLES
| -------------------------------------------------- -----------------
|
| ['dsn'] La cadena DSN completa describe una conexión a la base de datos.
| ['nombre de host'] El nombre de host de su servidor de base de datos.
| ['username'] El nombre de usuario utilizado para conectarse a la base de datos
| ['contraseña'] La contraseña utilizada para conectarse a la base de datos
| ['database'] El nombre de la base de datos a la que desea conectarse
| ['dbdriver'] El controlador de la base de datos. por ejemplo: mysqli.
| Actualmente compatible:
| cubrid, ibase, mssql, mysql, mysqli, oci8,
| odbc, pdo, postgre, sqlite, sqlite3, sqlsrv
| ['dbprefix'] Puede agregar un prefijo opcional, que se agregará
| al nombre de la tabla cuando se usa la clase Query Builder
| ['pconnect'] VERDADERO / FALSO - Si se debe usar una conexión persistente
| ['db_debug'] TRUE / FALSE - Si se deben mostrar los errores de la base de datos.
| ['cache_on'] TRUE / FALSE - Habilita / deshabilita el almacenamiento en caché de consultas
| ['cachedir'] La ruta a la carpeta donde se deben almacenar los archivos de caché
| ['char_set'] El juego de caracteres utilizado para comunicarse con la base de datos
| ['dbcollat'] La intercalación de caracteres utilizada para comunicarse con la base de datos
| NOTA: para las bases de datos MySQL y MySQLi, esta configuración solo se usa
| como una copia de seguridad si su servidor ejecuta PHP <5.2.3 o MySQL <5.0.7
| (y en las consultas de creación de tablas realizadas con DB Forge).
| Existe una incompatibilidad en PHP con mysql_real_escape_string () que
| puede hacer que su sitio sea vulnerable a la inyección de SQL si está utilizando un
| conjunto de caracteres de múltiples bytes y ejecutan versiones menores que estos.
| Los sitios que usan el conjunto de caracteres de la base de datos Latin-1 o UTF-8 y la intercalación no se ven afectados.
| ['swap_pre'] Prefijo de tabla predeterminado que debe intercambiarse con el dbprefix
| ['encrypt'] Si se usa o no una conexión encriptada.
|
| Los controladores 'mysql' (en desuso), 'sqlsrv' y 'pdo / sqlsrv' aceptan TRUE / FALSE
| Los controladores 'mysqli' y 'pdo / mysql' aceptan una matriz con las siguientes opciones:
|
| 'ssl_key' - Ruta al archivo de clave privada
| 'ssl_cert': ruta al archivo de certificado de clave pública
| 'ssl_ca' - Ruta al archivo de la autoridad del certificado
| 'ssl_capath' - Ruta a un directorio que contiene certificados de CA confiables en formato PEM
| 'ssl_cipher' - Lista de cifrados * permitidos que se utilizarán para el cifrado, separados por dos puntos (':')
| 'ssl_verify' - TRUE / FALSE; Si verifica el certificado del servidor o no (solo 'mysqli')
|
| ['compress'] Si se usa o no la compresión del cliente (MySQL solamente)
| ['stricton'] TRUE / FALSE - fuerza las conexiones de 'Modo estricto'
| - bueno para garantizar SQL estricto mientras se desarrolla
| ['ssl_options'] Se usa para establecer varias opciones SSL que se pueden usar al hacer conexiones SSL.
| ['failover'] array - Una matriz con 0 o más datos para las conexiones si la principal fallara.
| ['save_queries'] TRUE / FALSE - Ya sea para "guardar" todas las consultas ejecutadas.
| NOTA: deshabilitar esto también desactivará efectivamente ambos
| $ this-> db-> last_query () y perfilado de consultas DB.
| Cuando ejecuta una consulta, con esta configuración establecida en TRUE (valor predeterminado),
| CodeIgniter almacenará la declaración de SQL para fines de depuración.
| Sin embargo, esto puede causar un gran uso de memoria, especialmente si ejecuta
| una gran cantidad de consultas SQL ... deshabilitar esto para evitar ese problema.
|
| La variable $ active_group le permite elegir a qué grupo de conexión
| activar. Por defecto solo hay un grupo (el grupo 'predeterminado').
|
| Las variables $ query_builder le permiten determinar si cargar o no
| la clase de generador de consultas.
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'ControlApp',
	'password' => 'b6vDZOxVzZDJzXv4',
	'database' => 'bop',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

$db['lenox'] = array(
	'dsn'	=> '',
	'hostname' => '192.168.2.18',
	'username' => 'intranet',
	'password' => 'intranetbingo',
	'database' => 'controlLenox2',
	'dbdriver' => 'sqlsrv',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);


$db['bejerman'] = array(
	'dsn'	=> '',
	'hostname' => 'SRVBEJERMAN',
	'username' => 'sisbejerman',
	'password' => 'b1ng0.2019',
	'database' => 'sbdabing',
	'dbdriver' => 'sqlsrv',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
