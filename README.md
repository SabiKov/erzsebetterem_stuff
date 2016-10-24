# erzsebetterem_stuff
This repository contains a cordova mobile app (was built for android along with JQuery Mobile UI framework), DB (SQL), APIs (PHP -> CRUD functions), and a website (Materialize, CSS, and HTML5).

(The application's interface was written in Hungarian language and it uses Hungarian date and time as well)

I have removed all platforms from the phonegap/cordova file structure becuase the git complained about too long file name. 
In order to generate an instalable file you have to add your targeting platform. : 
	npm  -> 
			phonegap platfrom ls // display installed or availables platforms
			phonegap platform add "platform-name" // replace the quotation with platform name
			phonegap platform remove "platfrom-name" // if you wish to remove unwanted platform from your project.
			
The communication with the remote database, you need to configure the following details
	- Set up your DB table and PHP connection
	- Change all the link within the AJAX functions! 
	- I added a API key for fun so I would like to highlight that the lengthy string is not secure at all in a real-word scenario!
