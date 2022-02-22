# MumPI 3.0.0

---
### Note: 
Work is ongoing for refactoring MumPI to operate with PHP 7.4 and ZeroC Ice 3.7.
 
We recommend that you do not use this fork until it has been pulled back into the main project on @Kissaki's repository, or failing that, wait until this callout is removed from the master branch of this repo when work is completed.

---

MumPI is your Webinterface written in PHP for your Mumble Server ("Murmur") using the Ice-Middleware.

For installation notices, see INSTALL.txt or better yet https://github.com/Kissaki/MumPI/wiki/Installation  
For FAQ see https://github.com/Kissaki/MumPI/wiki/FAQ  
For Updates follow http://kcode.de/wordpress/category/development/mumble_php_interface as feed http://kcode.de/wordpress/category/development/mumble_php_interface/feed  

There is a CAPTCHA generated on the Registrations screen for users.  This requires the PHP GD extension, so be sure to install and enable that and reload your Apache/nginx server before installation of MumPI.

To access the admin area, add /admin/ to your url.  
To access the viewer, add /viewer/ to your url.  
To access the user, add /user/ to your url. (redirect in place)  
To get JSON data in the [CVP](http://wiki.mumble.info/wiki/Channel_Viewer_Protocol) format: `?view=json&serverId=1`  
To get JSON data in JSONP style: `?view=json&serverId=1&callback=?`
  

On first admin-login your admin account will be created. No need to manually create your first admin account yourself. Just login and admin-away!


Note on accounts:  
The interface is using a local database for storing mumpi admin accounts etc.
This has nothing to do with mumble or murmur accounts, but only the interface itself.
At this moment, filesystem and individual files are totally sufficient and probably better in performance than a DBS like MySQL would be (just disk I/O rather than tcp connections and a separate system to call).


3rd Party things:
Icons from
http://findicons.com/pack/1156/fugue
http://findicons.com/pack/1581/silk
