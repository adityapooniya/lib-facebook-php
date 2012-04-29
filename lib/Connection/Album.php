<?php
require_once 'Abstract.php';

class LibFacebook_Connection_Album extends LibFacebook_Connection_Abstract
{

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