<?php
require_once 'Abstract.php';

class LibFacebook_Connection_Summary extends LibFacebook_Connection_Abstract
{

    /**
     * @param stdClass $data
     */
    public function __construct($data)
    {
        $this->_data = $data;
        foreach($this->_data as $key => $value) {
            if (is_array($value) && isset($value[0]) && !is_string($value[0])) {
                $this->_data->$key = new LibFacebook_Collection($value);
            } else if ($key === "from") {
                require_once('Summary.php');
                $this->_data->$key = new LibFacebook_Connection_Summary($value);
            } else if (is_object($value)) {
                require_once('Summary.php');
                $this->_data->$key = new LibFacebook_Connection_Summary($value);
            }
        }
        $this->init($data);
    }

    /**
     * Whether or not this object should be considered a summary
     * @var bool
     */
    protected $_isSummary = true;

    /**
     * If this connection is only a summary, we can use the associated ID to
     * retrieve the full data on the connection and return the generated full
     * connection object
     *
     * @return LibFacebook_Connection_Abstract
     */
    public function retrieve()
    {
        return LibFacebook::getInstance()->getById($this->_id);
    }

}