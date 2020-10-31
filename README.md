# Telegram-Simple-PHP-Bot
This is a simple and lightweight <strong>Telegram Bot</strong> written in pure <strong>PHP</strong>. I only edited a Telegram bot that is already in use and removed some stuff to provide a simple code for anyone who likes to run a new bot and develop it as fast as possible and I didn't test it. So you might see a few spelling errors when you upload it on your server, but there is nothing to worry about. You only need to correct them.

## Features
 - Database class (database.php based on <strong>PDO</strong>)
 - A class you may need to group your functions. (class.php)
 - A file to write independently functions. (functions.php)

## Telegram Bot API
I have implemented some API functions from the [Telegram Bot API](https://core.telegram.org/bots/api) guide that you can see them below:

 - Parsing the messages
 - Setting the keyboard
 - Sending the message to the user
 - Downloading the files from the telegram server.
 - Sending the photo from URL
 - Sending the video from URL
 - Sending the log to the admin

 ## Usage
 The only thing you need to change is your telegram bot token you received from Telegram:
 - class.php -> $this->botToken = "XXXXXXXXX:XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";
 - As I mentioned above maybe you need to correct a few spelling errors!
 - Enjoy...

 ## Contributing
Contributions are welcome. Feel free to open a pull request with your changes or new <strong>Kali</strong> commands related to any penetration testing approaches.
