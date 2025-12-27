<?php
header('Content-Type: application/json');

// This function asks the server for the path to its temporary directory (e.g., C:\xampp\tmp)
$temp_dir = sys_get_temp_dir();

// We will create our own subfolder inside the temp directory to stay organized
$target_dir = $temp_dir . "/fitness_uploads/";
if (!is_dir($target_dir)) {
    mkdir($target_dir, 0777, true);
}

$test_file = $target_dir . "permission_test.txt";
$file_content = "Success! The server can write to its temporary directory.";

if (file_put_contents($test_file, $file_content) !== false) {
    echo json_encode([
        "status" => "success",
        "message" => "File created in temp directory! Permissions are fixed.",
        "path" => $test_file
    ]);
} else {
    echo json_encode([
        "status" => "error",
        "message" => "Critical Error: Server cannot even write to its own temp directory."
    ]);
}
?>