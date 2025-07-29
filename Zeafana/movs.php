<?php
  
/* Store the path of source file */
$source_file = 'img/user.jpg';
  
// Get the current week number
$weekNumber = date('W');

// Get the current year
$year = date('Y');

// Create the directory path
$directoryPath = "foo/$year/Week$weekNumber/";

// Create the directory if it doesn't already exist
if (!is_dir($directoryPath)) {
    mkdir($directoryPath, 0755, true);

    // move the file to the destination folder
rename($source_file, $directoryPath . basename($source_file));

  }
  
 

 

?>