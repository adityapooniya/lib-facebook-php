#############
### ABOUT ###
#############

PHP Library to wrap the existing Facebook PHP SDK and allow for more a more
object-oriented usage of the social graph and the relationships between
various graph objects (a.k.a. "connections").

The goal of this library is to allow developers new to the Facebook API to
get their applications working more quickly, and in a more reusable manner.


################
### EXAMPLES ###
################


As an example, using the current PHP SDK one could write the following:

    $friends = $facebook->api(‘/me/friends’)

    if (is_array($friends)) { // did it return an array? maybe not!
        foreach ($friends as $friend) {

            $friend[‘albums’] = $facebook->api(“/{$friend[‘id’]}/albums”);

            if (is_array($friend[‘albums’])) {  // did it return an array? maybe not!

                foreach ($friend[‘albums’] as $album) {
                    // do something
                }
            }

        }
    }

Our goal, however, is to allow something like the following:

    $friends = $facebook->getMe()->getFriends() // returns result set

    if ($friends->getErrors()) { /* deal with it */ }
    // (just an idea) each result set could have a method ::getErrors() to
    // retrieve error text and there could be a global “allow exceptions”
    // setting to let exceptions bubble up so the developer can handle them
    // instead.

    foreach ($friends as $friend) {
        // $friends is an enumerable object so if there was an error before it
        // would only cause an empty result set here (no foreach() warnings!)

        foreach ($friend->getAlbums() as $album) {
            foreach ($album as $photos) {
                // Maybe Facebook_Connection_Album is iterable over its photos
            }
        }
    }


#############
### USAGE ###
#############

This code isn't all implemented yet, and there's a lot of work to do, but the
goal is to use the following style functionality:

    require_once('path/to/LibFacebook.php');

    $facebook = LibFacebook::getInstance();

    $facebook->setApiConfig(
        array(
            'appId'  => YOUR_APP_ID,
            'secret' => YOUR_APP_SECRET
        )
    );

    $user = $facebook->getUser(A_FACEBOOK_USER_ID);

    $albums = $user->getAlbums();
    $photos = $albums->current()->getPhotos(); // $user->getAlbums()->current()->getPhotos();

    $friends    = $user->getFriends();
    $friendName = $friends->current()->name; // $user->getFriends()->current()->name;


###############
### ROADMAP ###
###############

* Finish writing out base getters for inter-connection calls (e.g. $user->getPhotos())
* Begin work on connection setters (e.g. $user->addPhoto($data))
* Add validation for various requests (e.g. $user->getAlbums() requires permission 'user_albums', which was not requested from the user)
* Begin work on exceptions and exception handling for easy debugging.

* Collections: Determine method for dealing with collection "paging" by Facebook
** (Collections work as iterable groupings, such as the albums returned by getAlbums().  Facebook implements paging (only returning X results, and a link for the next page)).

