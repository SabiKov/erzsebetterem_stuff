# erzsebetterem_stuff
This repository contains a cordova mobile app (was built for android along with JQuery Mobile UI framework), DB (SQL), APIs (PHP -> CRUD functions), and a website (Materialize, CSS, and HTML5).

(The application's interface was written in Hungarian language and it uses Hungarian date and time format as well)

The following elements were removed: all platforms dependencies from the phonegap/cordova file structure (the git complained about too long file name.)

In order to generate an instalable file you have to add your targeting platform : 
	npm  -> 
			phonegap platfrom ls // display installed or availables platforms
			phonegap platform add "platform-name" // replace the quotation with platform name
			phonegap platform remove "platfrom-name" // if you wish to remove unwanted platform from your project.
	

The communication with the remote database, you need to configure the following details
	- Set up your SQL DB and upload the PHP APIs to the server, this allows the app to establish connection with server.
	- Change all the link within the AJAX functions (http links)! 
	- I added a API key for fun so I would like to highlight that the lengthy string is not secure at all in a real-word scenario!
	
Finally, the splash screen plugin was removed because the git didn't accept long path, if you would like to enjoy the feature you may need to re-add the plugin. -> phonegap add plugin "plugin name" (something like this) . It may be you need to add images/icons to the source folder in order to visualize the effect.
