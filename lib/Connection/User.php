<?php
require_once 'Abstract.php';

class LibFacebook_Connection_User extends LibFacebook_Connection_Abstract
{
    protected $_type = 'user';

    /**
     * @return LibFacebook_Collection
     */
    public function getAccounts()
    {
        return $this->getCollection("accounts", 'account');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getActivities()
    {
        return $this->getCollection("activities", 'activity');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getAdAccounts()
    {
        // @TODO requires special permission
        return $this->getCollection("adaccounts", 'adaccount');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getAlbums()
    {
        return $this->getCollection("albums", 'album');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getAppRequests()
    {
        return $this->getCollection("apprequests", 'apprequest');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getBooks()
    {
        return $this->getCollection("books", 'book');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getCheckIns()
    {
        return $this->getCollection("checkins", 'checkin');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getEvents()
    {
        return $this->getCollection("events", 'event');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getFamily()
    {
        return $this->getCollection("family", 'user');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getFeed()
    {
        return $this->getCollection("feed");
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getFriendLists()
    {
        return $this->getCollection("friendlists", 'friendlist');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getFriendRequests()
    {
        return $this->getCollection("friendrequests", 'friendrequest');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getFriends()
    {
        return $this->getCollection("friends", 'user');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getGroups()
    {
        return $this->getCollection("groups", 'group');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getHome()
    {
        return $this->getCollection("home");
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getInbox()
    {
        return $this->getCollection("inbox", 'thread');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getInterests()
    {
        return $this->getCollection("interests");
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getLikes()
    {
        return $this->getCollection("likes", 'like');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getLinks()
    {
        return $this->getCollection("links", 'link');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getMovies()
    {
        return $this->getCollection("movies", 'movie');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getMusic()
    {
        return $this->getCollection("music", 'music');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getNotes()
    {
        return $this->getCollection("notes", 'note');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getNotifications()
    {
        return $this->getCollection("notifications", 'notification');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getOutbox()
    {
        return $this->getCollection("outbox", 'thread');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getPayments()
    {
        // @TODO Requires App Access Token
        return $this->getCollection("payments", 'payment');
    }

    /**
     * Returns the permissions that this user has granted YOUR application
     *
     * @return LibFacebook_Collection|bool
     */
    public function getPermissions()
    {
        if (!isset($this->_data->permissions))
        {
            $permissions = $this->_getController()->getApi()->api("/{$this->id}/permissions");

            if (
                is_array($permissions)
                && isset($permissions['data'])
                && is_array($permissions['data'])
                && count($permissions['data'])
            ) {
                $this->_data->permissions =  (object) $permissions['data'][0];
            } else {
                $this->_data->permissions = false;
            }
        }
        return $this->_data->permissions;
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getPhotos()
    {
        // @TODO Requires App Access Token
        return $this->getCollection("photos", 'photo');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getPosts()
    {
        return $this->getCollection("posts");
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getScores()
    {
        return $this->getCollection("scores", 'score');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getStatuses()
    {
        return $this->getCollection("statuses", 'status');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getTagged()
    {
        return $this->getCollection("tagged");
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getTelevision()
    {
        return $this->getCollection("television", 'page');
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getUpdates()
    {
        return $this->getCollection("updates");
    }

    /**
     * @return LibFacebook_Collection
     */
    public function getVideos()
    {
        return $this->getCollection("videos", 'video');
    }

}