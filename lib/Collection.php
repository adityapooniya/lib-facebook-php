<?php

require_once 'Collection/Abstract.php';

class LibFacebook_Collection extends LibFacebook_Collection_Abstract
{
    public function __construct($data, $type=null)
    {
        if (isset($data)) {
            $this->_data = $data;

            // convert each connection into a proper connection object.
            foreach ($this->_data as $key => $connection) {
                $this->_connections[] = LibFacebook::generateConnection((object) $connection, $type);
            }
        }

        $this->_count = count($this->_connections);
    }

}