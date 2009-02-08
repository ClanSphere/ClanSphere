README
--------------------------

Install:

Upload all content of the main directory, excluding 'debug.php' and the directorys 'docs' and 'updates', to your webserver and grant higher directorys enough access to let install.php create an setup.php file during the installation that keeps your database-settings. Next open your browser and point it to the install.php file that gives you further instructions.


Update from older ClanSphere Versions:

Apply the SQL patch (if a new one is available inside the 'updates' directory, else skip this) file by loading it inside the browser window (menu point when logged in as admin: System -> Updates). Next upload all content of the main directory, excluding 'debug.php' and the directorys 'convert', 'docs' and 'updates', to your webserver and grant upload directorys enough access for file uploads to them.


Update from BXCP 0.3.2.2:

Due to internal changes that affect the inner core, please backup the database and ftp content that belong to the installation you are going to update and make a list of things you changed manually inside the modules. Second step is running the file 'bxcp_0322_to_clansphere.sql' on your page when logged in as admin at menu point System -> Updates. Third step is the deletion of all ftp content except logs, templates and uploads directory. Fourth step is to upload the new content via ftp. Next open setup.php with a text editor to change every $bx_db to $cs_db and $bx_log to $cs_log inside the file. Now all should run well again, if not see help instructions below.


Help:

Send questions and support requests to #clansphere on irc quakenet or the board at http://www.clansphere.net


Info:

Enjoy testing and please send us feedback to make it one of the best clan web-cms that are available opensource and free

your ClanSphere Team