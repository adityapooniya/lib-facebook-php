<?php

require 'api/facebook.php';

class LibFacebook
{
    /**
     * Stores any data that has already been retreived.
     *
     * @var array
     */
    protected $_data = array();

    protected $_connections = array();

    protected $_api;

    protected $_apiConfig;

    /**
     * Singleton instance
     *
     * Marked only as protected to allow extension of the class. To extend,
     * simply override {@link getInstance()}.
     *
     * @var LibFacebook
     */
    protected static $_instance = null;

    /**
     * Enforce singleton; disallow cloning
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Constructor
     *
     * @return LibFacebook
     */
    public function __construct()
    {
    }

    /**
     * Singleton instance
     *
     * @return LibFacebook
     */
    public static function getInstance()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Returns the Facebook SDK Object
     *
     * @return Facebook
     */
    public function getApi()
    {
        if ($this->_api === null) {
            $this->_api = new Facebook($this->getApiConfig());
        }
        return $this->_api;
    }

    /**
     * Sets the facebook API instance
     *
     * @param Facebook $api
     */
    public function setApi(Facebook $api)
    {
        $this->_api = $api;
    }


    /**
     * Returns the configuration settings for the Facebook SDK
     *
     * @return array
     *
     * @throws exception
     */
    public function getApiConfig()
    {
        if ($this->_apiConfig === null) {
            throw new Exception('Configuration has not been set');
        }
        return $this->_apiConfig;
    }

    /**
     * Store the configuration settings for the Facebook SDK
     *
     * @param array $config The configuration settings for the Facebook SDK
     *
     * @return void
     */
    public function setApiConfig(array $config)
    {
        $this->_apiConfig = $config;
    }

    /**
     * Returns a user by ID number
     *
     * @param number $id
     *
     * @return LibFacebook_Connection_User
     */
    public function getUser($id)
    {
        return $this->getById($id, 'user');
    }

    /**
     * Retrieves connection data from the Graph API via ID number and returns
     * the associated connection object... Uses cached data when available.
     *
     * @param number $id   Facebook Graph API ID number
     * @param string $type The connection type to return
     *
     * @return LibFacebook_Connection_Abstract
     */
    public function getById($id, $type=null)
    {
        $id = (string) $id;
        if (!isset($this->_connections[$id])) {
            if (!isset($this->_data[$id])) {
                $response = $this->getApi()->api("/{$id}");
                $this->_data[$id] = (object) $response;
            }
            $this->_connections[$id] = self::generateConnection(clone $this->_data[$id], $type);
        }
        return $this->_connections[$id];
    }

    /**
     * Returns a connection based on the data provided
     *
     * @static
     *
     * @param stdClass  $data Data returned by Facebook Graph API
     * @param string $type Manual setting to override the connection type
     *
     * @return LibFacebook_Connection_Abstract
     */
    public static function generateConnection(stdClass $data, $type = null)
    {
        if (is_object($data)) {
            if ($type) {
                $data->type = $type;
            }

            // If facebook adds a new data type, we want to catch the failure
            // to load the class, then allow it to continue on by loading a
            // summary.
            try {
                if(isset($data->type)) {
                    $type      = ucfirst($data->type);
                    $classPath = __DIR__ . DIRECTORY_SEPARATOR . "lib/Connection/{$type}.php";
                    $typeClass = "LibFacebook_Connection_{$type}";
                    if(file_exists($classPath)) {
                        require_once($classPath);
                        return new $typeClass($data);
                    }
                }
            } catch (Exception $e) {

            }

            require_once("lib/Connection/Summary.php");
            return new LibFacebook_Connection_Summary($data);
        }
    }

}