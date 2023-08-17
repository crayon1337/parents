<?php

declare(strict_types=1);

namespace App\Http\Service\DataProvider;

use Illuminate\Support\Facades\File;

trait CanReadJsonFile
{
    public function __construct(protected array $data)
    {
    }

    /**
     * This function will read data from a file and transform the data into DTO.
     *
     * @param string $filePath
     * @return YDataProvider|XDataProvider|CanReadJsonFile
     */
    public static function make(string $filePath): self
    {
        $fileContent = File::get(storage_path(path: $filePath));

        $data = json_decode(json: $fileContent, associative: true);

        return new self(data: $data);
    }

    /**
     * Validate that a given array has given keys.
     *
     * @param array $keys
     * @param array $array
     * @return bool
     */
    private function arrayHasKeys(array $keys, array $array): bool
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
        }

        return true;
    }
}
