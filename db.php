<?php
// 
//  db.php
//  mgmt cms
//  
//  Created by Dan Burby on 2010-09-10.
//  Copyright 2010 Dan Burby, Burby LLC. All rights reserved.
// 

$mgmtd = new mysqli(DB_HOST, DB_USER, DB_PW, DB_DB);

if ($mgmtd->connect_error) {
    die('Connect Error (' . $mgmtd->connect_errno . ') '. $mgmtd->connect_error);
}

?>