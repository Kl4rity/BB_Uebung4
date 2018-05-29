<?php
error_reporting(E_ALL);

include "controller/ListController.php";
include "services/Database.php";
include "views/JsonView.php";
include "models/ElectricModelItem.php";
include "models/Floor.php";
include "models/Device.php";
include "models/Project.php";
include "models/Room.php";
include "models/Sensor.php";

define ("DBHost", "localhost");
define ("DBName", "uebung3");
define ("DBUser", "root");
define ("DBPass", "");