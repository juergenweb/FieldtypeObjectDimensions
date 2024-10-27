# Change Log
All notable changes to this project will be documented in this file.

## [1.2.2] - 2023-06-14

This is the version that has been added to the ProcessWire module directory. The database scheme has been updated and a
lot of changes has been done to the code.
It has also been tested to work with the new PHP 8.2 version.

For users, which have downloaded a lower version before, have to uninstall the older version completely and to make a
fresh installation of this module. The most important reason for this is the database update.

Another major change concerns the API calls. This version offers different API calls for different output formattings
and 2 new methods to render combined strings. Please take a look in the docs. If you have an old installation, you have
to adapt the API calls to the new version.

## 2024-10-27

- **Support for RockLanguage added**

If you have installed the [RockLanguage](https://processwire.com/modules/rock-language/) module by Bernhard Baumrock, this module now supports the sync of the language files. This means that you do not have to take care about new translations after you have downloaded a new version of FieldtypeObjectDimensions. All new translations (at the moment only German translations) will be synced with your your ProcessWire language files. 

Please note: The sync will only take place if you are logged in as Superuser and $config->debug is set to true (take a look at the [docs](https://www.baumrock.com/en/processwire/modules/rocklanguage/docs/)).

The (old) CSV files usage is still supported.


