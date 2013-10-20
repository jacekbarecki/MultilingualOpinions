MultilingualOpinions
====================

A one-page PHP site for gathering user opinions and displaying them in different languages basing on the translations provided by the Google Translate API.

## Overview
This is a simple PHP application that allows a visitor to add a new opinion using a web form. The opinion is saved to 
the database along with the translations to different languages fetched from the Google Translate API. 
The page also displays the existing opinions along with their translations.

**Used technologies**
- the [PHPGoogleTranslator][translator] class to connect with the Google Translate API,
- the [SQLite][sqlite] database,
- the [Twitter Bootstrap][twitter] to get some nice look&feel.

## Setup


**The database**

Enter your SQLite database file name in `SqliteConnector.php`. If the file doesn't exists, it will be created 
automatically.

```php
    class SqliteConnector {
        private $_filename = 'opinions.db';
        ...
    }
```


**The Google Translate API**

Set up the PHPGoogleTranslator class as described in [the documentation][translator]. You can enable the test mode 
and no requests to the API will be made or enter your API key and use the API functionality.


**The list of used languages**

Enter the languages that are used in the site in the `Opinion.php` file:

```php
  class Opinion {
        private $_languages = array('en', 'fr', 'es');
        ...
  }
```

This list will be used to check which translations to fetch when adding an opinion.

**The language of submitted opinions**

When user submits the form, the opinion language is fetched from a hidden input field defined in `index.php`:
```
  <input type="hidden" name="language" id="inputLanguage" value="en">
```

If you want to implement different language versions of the form, change the field value depending on 
the language version that is currently displayed. 

## Usage
Upload the files to a server. Add some opinions. Read the existing ones. Have fun.

[translator]: https://github.com/jacek-b/PHPGoogleTranslator
[sqlite]: http://www.sqlite.org/
[twitter]: http://getbootstrap.com/
[demo]: https://github.com/
