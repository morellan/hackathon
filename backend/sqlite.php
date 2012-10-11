<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$dbname='base';
$base=new SQLiteDatabase($dbname, 0666, $err);
if ($err)
{ 
  echo "SQLite NOT supported.\n";
  exit($err);
}
else
{
  echo "SQLite supported.\n";
}  
?>
