<?php
namespace Src;
//use \Zend\Crypt\PublicKey\Rsa\PublicKey;
use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;
/**
 * Gerenciar conexões com o banco de dados
 *
 * @package \Src\DB
 * @author Jalon Vitor Cerqueira Silva 
 * @version 1.0.1
 * @created 18/08/2017
 */
class DB {
    const DB_SENHA_TEXTO = 0;
    const DB_SENHA_CRYPT = 1;
    
    /**
	 * Objeto que irá guardar a instância
	 */
	private static $instance;
    
    
    /**
	 * Objeto que irá guardar a instância
	 */
	public $con;
	
	/**
	 * Driver que será utilizado
	 * @var string
	 */
    private $driver;

	public function __construct() {
        global $em, $container;
		//$container->logger->info(__CLASS__.": nova instância");
    }

    /**
	 * Construtor para implemetar SINGLETON
	 *
	 * @return object
	 */
	public static function getInstance() {
		if (!isset(self::$instance)) {
			$cl = __CLASS__;
			self::$instance = new $cl;
		}
		return self::$instance;
	}
    
    /**
	 * Fazer conexão ao banco
	 *
	 * @param string $ip
	 * @param string $usuario
	 * @param string $senha
	 * @param string $banco
	 * @param string $indSenhaCript Indicador de senha criptografada (1 Criptografada, 0 não criptografada)
	 */
	public function conectar ( $dbParams ) {
		global $em, $container;

		/** 
		 * Salva o parâmetro de display erro do PHP
		 **/
		$dispErroSave	= ini_get('display_errors');
	
		/** 
		 * Altera o parâmetro para não mostrar os erros 
		 **/
		ini_set('display_errors',true);
	
		try {	
			/**
			 * Cria a adaptador da conexão
			 */
			$config = new \Doctrine\ORM\Configuration();
			$this->con = \Doctrine\DBAL\DriverManager::getConnection($dbParams, $config);

			/**
			 * Testa se a conexao foi bem sucedida
			*/
			
			if (!$dbParams['driver']) {
				$container->logger->error('parâmetros de banco de dados não informado: (database.driver)');
			}else{
				$this->setDriver($dbParams['driver']);
			}

			$this->testaConexao($dbParams['driver']);
	
		} catch (\Exception $e) {
			$container->logger->error($e->getMessage(),$e->getTraceAsString(),__CLASS__);
		}
	
		/** retornar o parâmetro de display erro **/
		ini_set('display_errors',$dispErroSave);
        
		try {
			$isDevMode 	= true;
			$config 	= Setup::createAnnotationMetadataConfiguration(array('ENTITY_PATH'), $isDevMode, null, null, false);
			$em 		= EntityManager::create($this->con, $config);
				
			$driver = new \Doctrine\ORM\Mapping\Driver\DatabaseDriver($em->getConnection()->getSchemaManager());
			$driver->setNamespace('Entidades\\');
			
			$em->getConfiguration()->setMetadataDriverImpl($driver);
		} catch (\Exception $e) {
			$container->logger->error($e->getMessage());
		}
    }
    
    /**
	 * Testar a conexão
	 */
	private function testaConexao ($driver) {
        global $container;

		switch ($driver) {
			case "mysqli":
			case "pdo_mysql":
				$sql	= "SELECT USER() AS USUARIO";
				break;
			default:
			$container->logger->error("Driver: ".$driver." ainda não implementado !!!");
		}
		
		try {
			$res	= @$this->con->query($sql);
		} catch (\Exception $e) {
			$erro	= "[".__CLASS__."] [.".__FUNCTION__."]". $e->getMessage();
			$container->logger->error($erro);
        }
        
        //$container->logger->info( 'Conectado!' );
	}
	
		/**
	 * Definir variáveis globais no banco (session variables)
	 */
	public function setLoggedUser ($codUsuario) {
		global $container;

		if ( !isset($codUsuario) ) $codUsuario = "NULL";
		
		switch ($this->getDriver() ) {
			//case "mysqli":
			//case "mysql":
			case "pdo_mysql":
				$sql	= "SET @SL_USER = ".$codUsuario;
				break;
			case "oci8":
				$sql	= "exec dbms_application_info.set_client_info('".$codUsuario."');";
				break;
			default:
			    $container->logger->error("Driver: ".$this->getDriver()." ainda não implementado !!!");
		}
	
		try {
			$res	= @$this->con->query($sql);
		} catch (\Exception $e) {
			$erro	= "[".__CLASS__."] [.".__FUNCTION__."]". $e->getMessage();
			$container->logger->error($erro);
		}
	}

		/**
	 * Resgatar o usuário logado no sistema através das variáveis de sessão
	 */
	public function getLoggedUser () {
		switch ($this->getDriver()) {
			case "mysqli":
			case "pdo_mysql":
			//case "mysql":
				$sql	= "SELECT @SL_USER as USUARIO";
				break;
			case "oci8":
				$sql	= "SELECT sys_context('USERENV', 'CLIENT_INFO') USUARIO FROM DUAL";
				break;
			default:
				Erro::halt("Driver: ".$this->getDriver()." ainda não implementado !!!");
		}
	
		$info	= $this->extraiPrimeiro($sql);
		
		if (!isset($info->USUARIO)) {
			die('Não foi possível resgatar o usuário logado no sistema !!!');
		}else{
			return $info->USUARIO;
		}
	}

	public function extraiPrimeiro($sql, $parametros = null) {		
		try {
			$statement 	= $this->con->prepare($sql);
			$statement->execute($parametros);
			$result		= $statement->fetch();
			
			return ((object) $result);
						
		} catch (\Exception $e) {
			Erro::halt($e->getMessage(), $e->getTraceAsString(),__CLASS__);
			//return '[ERR]'.$e->getMessage();
			throw new \Exception($e->getMessage());
		}
	}

	private function setDriver($driver){
		$this->driver = $driver;
	}

	private function getDriver(){
		return $this->driver;
	}
}

