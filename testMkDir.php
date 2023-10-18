<?php

$testDirectory = '/mnt/paphotos/zSketches/test';

if (mkdir($testDirectory, 0777, true)) {
    echo "Directory '{$testDirectory}' created successfully.";
} else {
    echo "Failed to create directory '{$testDirectory}' - " . error_get_last()['message'];
}