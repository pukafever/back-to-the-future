<?php

namespace BackToTheFuture\data;

use BackToTheFuture\utilities\Reporter;

/**
 * Manipulate products in the database.
 */
class Product
{
    /** Add a product to the database.
     * @param string $partNumber The product part-number.
     * @param integer $updateInterval The time, in days, between each update of the stock and the prices.
     * @param string $manufacturer The part manufacturer.
     *
     * @return array The result of the operation.
     */
    public function add(string $partNumber, int $updateInterval, string $manufacturer): array
    {
        $partNumber = strtoupper($partNumber);
        $tracked_since = date('Y-m-d');
        $database = new Database();
        $reporter = new Reporter();
        $query = $database->connection->prepare('INSERT INTO products (part_number, tracked_since, update_interval, state, manufacturer) VALUES (?, ?, ?, ?, ?);');

        return ($query->execute(array(
            $partNumber,
            $tracked_since,
            $updateInterval,
            -1,
            $manufacturer
        )))
            ? ($reporter->format(0, 'Part-number successfully added.', ''))
            : ($reporter->format(2, 'SQL error.', $query->errorInfo()));
    }
}
