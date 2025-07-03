<?php

namespace App\Helpers;

use Exception;

class JSONReader {
    
    public function read(string $filePath): array {
        
        if (!file_exists($filePath)) {
            throw new Exception("JSON file not found: {$filePath}");
        }

        $jsonContent = file_get_contents($filePath);
        
        if ($jsonContent === false) {
            throw new Exception("Failed to read JSON file: {$filePath}");
        }

        $data = json_decode($jsonContent, true);
        if ($data === null) {
            throw new Exception("Invalid JSON in file: {$filePath}");
        }

        return $data;
    }
}
