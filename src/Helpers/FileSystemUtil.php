<?php

namespace App\Helpers;

class FileSystemUtil
{
    public static function getFilesFromFolder(string $folder): array
    {
        $files = [];

        // Check if the path is a directory
        if (is_dir($folder)) {
            // Open the directory
            if ($handle = opendir($folder)) {
                // Iterate through directory contents
                while (($entry = readdir($handle)) !== false) {
                    // Skip current and parent directory pointers
                    if ($entry != "." && $entry != "..") {
                        $path = $folder . DIRECTORY_SEPARATOR . $entry;
                        // If the current entry is a directory, recursively call the function
                        if (is_dir($path)) {
                            $files = array_merge($files, self::getFilesFromFolder($path));
                        } else {
                            // If the current entry is a file, add it to the files array
                            $files[] = $path;
                        }
                    }
                }
                // Close the directory handle
                closedir($handle);
            }
        }

        return $files;
    }
}