<?php

require_once(__DIR__ . DIRECTORY_SEPARATOR . '../Collection.php');

abstract class LibFacebook_Connection_Abstract
{
    protected $_type;

    /**
     * Stores all data
     *
     * @var Array
     */
    protected $_data = array();

    /**
     * Whether the instance should be considered a summary
     *
     * @var bool
     */
    protected $_isSummary = false;

    /**
     * Returns the LibFacebook instance
     *
     * @return LibFacebook
     */
    protected function _getController()
    {
        return LibFacebook::getInstance();
    }

    /**
     * Instance Constructor
     *
     * @param array $data
     *
     * @return LibFacebook_Connection_Abstract
     *
     * @throws Exception
     */
    public function __construct($data)
    {
        if ($data->type !== $this->_type) {
            throw new Exception("Invalid data for Facebook ${(ucfirst($this->_type))}");
        }
        $this->_data = $data;
        foreach($this->_data as $key => $value) {
            if (is_array($value) && isset($value[0]) && !is_string($value[0])) {
                $this->_data->$key = new LibFacebook_Collection($value);
            } else if ($key == "from") {
                require_once('Summary.php');
                $this->_data->$key = new LibFacebook_Connection_Summary($value);
            } else if (is_object($value)) {
                require_once('Summary.php');
                $this->_data->$key = new LibFacebook_Connection_Summary($value);
            }
        }
        $this->init($data);
    }

    protected function init()
    {
    }

    /**
     * Magic method to treat data array entries as properties
     *
     * @param string $name Name of the property
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (is_object($this->_data) && isset($this->_data->$name)) {
            return $this->_data->$name;
        } elseif (is_array($this->_data) && isset($this->_data[$name])) {
            return $this->_data[$name];
        }
        return null;
    }

    /**
     * Returns whether the given connection is only a summary
     *
     * @return bool
     */
    public function isSummary()
    {
        return $this->_isSummary;
    }

    /**
     * Returns the owner, if available, otherwise throws an exception.
     *
     * @return LibFacebook_Connection_Abstract
     *
     * @throws Exception
     */
    public function getOwner()
    {
        if (!$this->hasOwner()) {
            return false;
        }
        return $this->_getController()->getUser($this->getOwnerId());
    }

    /**
     * Returns whether a viable owner user ID is available.
     *
     * @return bool
     */
    public function hasOwner()
    {
        return (
            isset($this->_data->from)
            && is_object($this->_data->from)
            && $this->from->id
            && is_numeric($this->from->id)
        );
    }

    /**
     * Returns the user ID of the connection owner, if available.
     *
     * @return  number
     *
     * @throws Exception
     */
    public function getOwnerId() {
        if (!$this->hasOwner()) {
            return false;
        }
        return $this->from->id;
    }

    /**
     * Returns a string value
     *
     * @return string
     */
    public function __toString()
    {
        if ($this->name) {
            return $this->name;
        } else if ($this->story) {
            return $this->story;
        } else {
            return get_class($this);
        }
    }

    /**
     * Retrieves a collection associated with the given connection
     *
     * @param string      $collectionType The name of the collection being retrieved
     * @param string|null $connectionType Type of the connections contained by
     *                                    the collection, or null for auto-detect
     *
     * @return LibFacebook_Collection
     *
     * @throws Exception if $collectionType is not a string, or is an empty string
     */
    public function getCollection($collectionType, $connectionType=null)
    {
        $url = "/{$this->id}/{$collectionType}/";

        if (!is_string($collectionType) || $collectionType === "") {
            throw new Exception("Collection type must be string or must be null to set as default");
        }

        if (!isset($this->_data->$collectionType)) {
            $response = $this->_getController()->getApi()->api($url);

            $data = $response['data'];

            if (isset($connectionType) && is_string($connectionType) && $connectionType !== "") {
                foreach($data as $datum)
                {
                    $datum['type'] = $connectionType;
                }
            }

            $this->_data->$collectionType = new LibFacebook_Collection($data, $connectionType);
        }

        return $this->_data->$collectionType;

    }

}