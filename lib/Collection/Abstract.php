<?php

abstract class LibFacebook_Collection_Abstract implements SeekableIterator, Countable, ArrayAccess
{

    // TODO Implement paging functionality

    /**
     * Stores the connection type for the collection
     *
     * @var string
     */
    protected $_connectionType;


    /**
     * Gets the controller
     *
     * @return LibFacebook
     */
    protected function _getController()
    {
        return LibFacebook::getInstance();
    }

    /**
     * Raw data returned from Facebook API
     *
     * @var array
     */
    protected $_data = array();

    /**
     * Array of the connections stored in the collection
     *
     * @var Array;
     */
    protected $_connections = array();

    /**
     * Iterator pointer.
     *
     * @var integer
     */
    protected $_pointer = 0;

    /**
     * How many data rows there are.
     *
     * @var integer
     */
    protected $_count;

    /**
     * Rewind the Iterator to the first connection.
     * Similar to the reset() function for arrays in PHP.
     * Required by interface Iterator.
     *
     * @return LibFacebook_Collection_Abstract Fluent interface.
     */
    public function rewind()
    {
        $this->_pointer = 0;
        return $this;
    }

    /**
     * Return the current connection.
     * Similar to the current() function for arrays in PHP
     * Required by interface Iterator.
     *
     * @return LibFacebook_Connection_Abstract current connection from the collection
     */
    public function current()
    {
        if ($this->valid() === false) {
            return null;
        }

        return $this->_connections[$this->_pointer];
    }

    /**
     * Return the identifying key of the current connection.
     * Similar to the key() function for arrays in PHP.
     * Required by interface Iterator.
     *
     * @return int
     */
    public function key()
    {
        return $this->_pointer;
    }

    /**
     * Move forward to next connection.
     * Similar to the next() function for arrays in PHP.
     * Required by interface Iterator.
     *
     * @return void
     */
    public function next()
    {
        ++$this->_pointer;
    }

    /**
     * Check if there is a current connection after calls to rewind() or next().
     * Used to check if we've iterated to the end of the collection.
     * Required by interface Iterator.
     *
     * @return bool False if there's nothing more to iterate over
     */
    public function valid()
    {
        return $this->_pointer >= 0 && $this->_pointer < $this->_count;
    }

    /**
     * Returns the number of connections in the collection.
     *
     * Implements Countable::count()
     *
     * @return int
     */
    public function count()
    {
        return $this->_count;
    }

    /**
     * Take the Iterator to position $position
     * Required by interface SeekableIterator.
     *
     * @param int $position the position to seek to
     *
     * @return LibFacebook_Collection_Abstract
     *
     * @throws LibFacebook_Exception
     */
    public function seek($position)
    {
        $position = (int) $position;
        if ($position < 0 || $position >= $this->_count) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . '../Exception.php';
            throw new LibFacebook_Exception("Illegal index $position");
        }
        $this->_pointer = $position;
        return $this;
    }

    /**
     * Check if an offset exists
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->_connections[(int) $offset]);
    }

    /**
     * Get the row for the given offset
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     *
     * @return LibFacebook_Connection_Abstract
     *
     * @throws LibFacebook_Exception
     */
    public function offsetGet($offset)
    {
        $offset = (int) $offset;
        if ($offset < 0 || $offset >= $this->_count) {
            require_once __DIR__ . DIRECTORY_SEPARATOR . '../Exception.php';
            throw new LibFacebook_Exception("Illegal index $offset");
        }
        $this->_pointer = $offset;

        return $this->current();
    }

    /**
     * Does nothing
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     *
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
    }

    /**
     * Does nothing
     * Required by the ArrayAccess implementation
     *
     * @param string $offset
     */
    public function offsetUnset($offset)
    {
    }

}