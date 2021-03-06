<?php

namespace BackToTheFuture\utilities;

use InvalidArgumentException;

/**
 * Construct a list of part numbers from a file.
 */
class Reader
{

    /** Reads the two first columns of CSV file.
     * @param string $path The path to the file.
     *
     * @return array
     */
    public function readCSVFile(string $path): array
    {
        $content = array();
        if (!file_exists($path)) {
            throw new InvalidArgumentException("File '" . $path . "' does not seem to exist.", 1);
        }

        $handle = fopen($path, 'r');
        while (($data = fgetcsv($handle, 1_000, ';')) !== false) {
            if (isset($data[0]) && isset($data[1])) {
                $content[$data[0]] = $data[1];
            } else {
                $content[$data[0]] = $data[0];
            }
        }

        return $content;
    }

    /** Reads a file input in YAML format.
     * @param string $path
     *
     * @return array
     */
    public function readYAMLFile(string $path): array
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException("File '" . $path . "' does not seem to exist.", 1);
        }

        return yaml_parse_file($path);
    }

    /** Reads a YAML string and return an array.
     * @param string $input The YAML string to parse.
     *
     * @return array
     */
    public function readFromString(string $input): array
    {
        return yaml_parse($input);
    }
}
