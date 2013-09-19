StormDB
=======

StormDB is an NoSQL database engine written in & for PHP. It is inspirated by MongoDB and Nette\Database.

__This engine is under development so there might be many bugs!__

Usage
-----

For tests running you have to install dependies by composer and write a `localSetup.php` and write in there:
```
<?php
require '../vendor/cactucs/debugger/loader.php';
Debugger::setDebugger('Default'); // Or other debugger. See Cactucs/Debugger docs
```


See `Tests` folder for examples.


Authors
-------

 - Vojta Staněk <stanekv01@gmail.com>  - Project founder

 
Folders
-------
 - `Databases`: Databases used for testing
 - `StormDB`: The core
  - `StormLoader.php`: loads StormDB
 - `Tests`: Test (can be used as examples)
 - `vendor`: External libs (e.g. cactucs/debugger)
