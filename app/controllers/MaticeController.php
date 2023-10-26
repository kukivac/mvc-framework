<?php

namespace App\Controllers;

use System\Core\Controllers\ViewController;

/**
 * Controller DefaultController
 *
 * @package App\Controllers
 */
class MaticeController extends ViewController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Sets default homepage
     *
     * @param array $params
     * @param array|null $query
     *
     * @return void
     */
    public function process(array $params, array $query = null)
    {
        $numbers = range(0, 1000);
        shuffle($numbers);
        $matice = [];
        for ($i = 0; $i < 10; $i++) {
            for ($j = 0; $j < 10; $j++) {
                $matice[$i][$j] = array_shift($numbers);
            }
        }
        // Flatten the 2D array
        $flattenedArray = array_merge(...$matice);
        // Sort the flattened array
        sort($flattenedArray);
        // Reconstruct the 2D array
        $sortedArray = [];
        $rows = count($matice);
        $cols = count($matice[0]);
        $index = 0;

        for ($i = 0; $i < $rows; $i++) {
            for ($j = 0; $j < $cols; $j++) {
                $sortedArray[$i][$j] = $flattenedArray[$index++];
            }
        }
        $tables["Neseřazená"] = $matice;
        $tables["Seřazená"] = $sortedArray;

        $this->head->addMeta("description", "Homepage of website");
        $this->head->addMeta("keywords", "homepage,home");
        $this->head->addTitle("Homepage");
        $this->data["tables"] = $tables;
        $this->setView('default');
    }
}