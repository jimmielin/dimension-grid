dimension-grid
=============

A failed game
-------------

**Dimension.Grid**. A lame name, certainly not created by a marketer. This was a eRepublik (http://erepublik.com) game clone developed solely by myself in 2011, for the purpose of actually creating a game that was pleasant to play instead of everyone being angry with the admins (this was a very common thing at that time, not sure about now though). The development of this took roughly 2 months (my entire summer vacation) and I was about to market this then I simply ran out of patience, and failure to do proper launching made this plan die out and the entire project ending abruptly.

I've decided to release the entire source code, including the CakePHP build it was designed to run on (1.x) here, licensed under the GNU GPLv2 (this ensures anyone using this code will have to open-source it too) and although it might not be use to anyone anymore (too old, no interest, etc...) it is left here solely for historical reasons, and maybe someone will eventually find a use for it. Just in my dreams, though :)

Documentation
-------------

The code included should be mostly self-documenting. Although I fail at marketing, I do have a pretty clean coding style I've kept consistent throughout the entire application and the whole 6-7 years of web development work, therefore it should be fairly easy to understand.

Code Quality
-------------

I am usually very confident to say my code has a minimal amount of bugs, and I am still confident about the code quality that I've written during that summer. Though it's been 2 years, best practices have changed and evolved significantly, and maybe this is not as up-to-date as it would have been if released two years ago.

But it works pretty well. I think.

Database
-------------

Sensitive data removed, but everything is in `database.sql` in the root folder. Password hashing is in `Controllers/users_controller.php` I believe.
Database structure is pretty clear, it's MySQL 5, just throw it through phpMyAdmin / SQLBuddy and it will all load up.

Resources Used (Removed from source to avoid copyright issues)
-------------

- Famfamfam Silk Icons should be located at /app/webroot/img/silk
- Fugue Icons from Yusuke Kamiyamane should be located at /app/webroot/img/fugue and /app/webroot/img/fugue-32
- Flag icons using 2-char country codes should be located at /app/webroot/img/flags (Famfamfam were used originally) and 48px High flags should be located at /app/webroot/img/flags-48. (I forgot the source though, sorry. I still have the icons and if anyone wants them I can provide them to you. Not hosting on Github though to avoid copyright. I *think* it's IconDrawer)

- jQuery, etc...

Who to contact
-------------

I am not maintaining this code, nor I remember anything enough to probably answer your questions. But if you really want to reach me for some offer (since I still maintain rights to change the license of this code to closed-source if anyone wishes to use it in production), `jimmie.lin` (gmail) will do. Thank you for reading.

~ Jimmie Lin
2013.7.31