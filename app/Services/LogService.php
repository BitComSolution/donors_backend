<?php

namespace App\Services;

class LogService
{


    public static function createFile($full_path, $name, $fields)
    {
        $dir = storage_path('csv/' . $full_path);
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        $filename = $dir . "/$name.csv";
        $handle = fopen($filename, 'a');
        fputcsv($handle, $fields);
        return $handle;
    }

    public static function addLine($handle, $fields, $data)
    {
        $line = [];
        foreach ($fields as $field) {
            $value = $data[$field] ?? '';
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }

            $line[] = $value;
        }
        fputcsv($handle, $line);
    }

    public static function closeFile($handle)
    {
        fclose($handle);
    }
}
