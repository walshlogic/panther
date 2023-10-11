<?php
// for testing only
// not called in any code, run directly to test
// simple code to check is network location is writeable for log files or other writes
if (is_writable('/mnt/paphotos/photos/zPantherErrorLog/')) {
    echo 'The path is writable';
} else {
    echo 'The path is not
writable';
}