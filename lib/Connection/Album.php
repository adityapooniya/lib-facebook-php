<?php
require_once 'Abstract.php';

class LibFacebook_Connection_Album extends LibFacebook_Connection_Abstract
{

    // TODO implement connection setters (e.g. ::addPhoto($data))

    /**
     * Stores the connection type string
     *
     * @var string
     */
    protected $_type = 'album';

    /**
     * @return LibFacebook_Collection
     */
    public function getPhotos()
    {
        return $this->getCollection("/{$this->id}/photos", 'photo');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getLikes()
    {
        return $this->getCollection("/{$this->id}/likes", 'like');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getComments()
    {
        return $this->getCollection("/{$this->id}/comments", 'comment');
    }

}