<?php
function logMessage($message, $logFilePath = './logs/log.txt')
{
    // Check if the directory exists
    $logDir = dirname($logFilePath);
    if (!is_dir($logDir)) {
        // Create the directory if it doesn't exist
        if (!mkdir($logDir, 0755, true)) {
            die('Failed to create log directory');
        }
    }

    // Create the log message
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[$timestamp] $message\n";

    // Write the log message
    if (file_put_contents($logFilePath, $formattedMessage, FILE_APPEND) === false) {
        die('Failed to write to log file');
    }
}
?>