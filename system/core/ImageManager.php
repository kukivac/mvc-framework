<?php

namespace system\core;

include_once("../vendor/autoload.php");

use app\config\ImageOptimizerConfig;
use Intervention\Image\ImageManagerStatic as Image;
use Intervention\Image\Exception\NotWritableException;
use RuntimeException;


/**
 * Manager ImageManager
 * pro více info http://image.intervention.io/getting_started/introduction
 *
 * @package app\models
 */
class ImageManager
{
    /**
     * Edits image to default parameters defined in ImageOptimizerConfig
     *
     * @param string $imgURL
     *
     * @throws RuntimeException
     * @return void
     */
    static function defaultImage(string $imgURL): void
    {
        try {
            self::editImage($imgURL,$imgURL,ImageOptimizerConfig::$defaultImageWidth,ImageOptimizerConfig::$defaultImageHeight);
        } catch (NotWritableException $ex) {
            throw new RuntimeException;
        }
    }

    /**
     * Makes thumbnail version of image, by defined resolution in ImageOptimizerConfig
     *
     * @param string $imgURL
     *
     * @throws RuntimeException
     * @return void
     */
    static function makeThumbnail(string $imgURL) :void
    {
        $newURL = "images/thumbnail/" . array_reverse(explode("/", $imgURL))[0];
        $oldURL = $imgURL;
        try {
            self::editImage($newURL,$oldURL,ImageOptimizerConfig::$thumbnailWidth,ImageOptimizerConfig::$thumbnailHeight);
        } catch (NotWritableException $ex) {
            throw new RuntimeException;
        }
    }

    /**
     * @param $newURL
     * @param $oldURL
     * @param $targetWidth
     * @param $targetHeight
     */
    static function editImage($newURL,$oldURL,$targetWidth,$targetHeight)
    {
        $img = Image::make($oldURL);

        $height = $img->height();
        $width = $img->width();
        //na šířku
        if ($width > $height) {
            if ($width > $targetWidth) {
                $img->resize($targetWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $img->save($newURL);
            }
        }
        //na výšku
        else {
            if ($height > $targetHeight) {
                $img->resize(null, $targetHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else {
                $img->save($newURL);
            }
        }
        $img->save($newURL);
    }
}
