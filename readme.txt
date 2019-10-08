This PHP project is using Phalcon framework, you need the phalcon installed at the computer, I use php 7.2 but it should be running well at php 7 above

Code Structures
- app (all code store here)
    - config (as we dont have any frontend display, only config.php is matter)
    - controller (no need for this project, but if this app need to be accessible then put the base and protected here)
    - modules (no need for this project, but if this app need to be accessible then put the controller here in modular way)
    - system (all lib, model and task here, our main logic should be store in lib and we can access the task via console, i will explain later)
- public (for assets and media, not use in this project)


To start execute the cli.php
e.g.: php [path]/public/cli.php
To get the user id execute command: php [path]/public/cli.php user show (check the help at php [path]/public/cli.php for more command)