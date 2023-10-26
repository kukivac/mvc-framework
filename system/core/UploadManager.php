<?php

namespace System\Core;

use Nette\Http\FileUpload as FileUpload;
use RuntimeException;

class UploadManager
{
    /**
     * @param $values
     *
     * @return bool|array
     */
    public static function UploadMultipleImages($values): array|bool
    {
        $filenames = [];
        $sanitizedFileNames = [];
        try {
            foreach ($values as $file) {
                /**
                 * @var FileUpload $file
                 */
                $ext = match ($file->getImageFileExtension()) {
                    "jpeg" => "jpg",
                    default => $file->getImageFileExtension(),
                };
                //Filename with extension
                array_push($filenames, ($filename = hash("sha256", $file->getTemporaryFile()) . "." . $ext));
                //File name with sanitized name
                array_push($sanitizedFileNames, $file->getSanitizedName());
                //Filename with target directory
                $filenameWDir = sprintf(
                    'images/fullView/%s',
                    $filename
                );

                if (!move_uploaded_file(
                    $file->getTemporaryFile(),
                    $filenameWDir
                )) {
                    throw new RuntimeException();
                }
                ImageManager::defaultImage($filenameWDir);
                ImageManager::makeThumbnail($filenameWDir);
            }
        } catch (RuntimeException) {
            if (!empty($filenames)) {
                foreach ($filenames as $filename) {
                    unlink("images/fullView/" . $filename);
                    unlink("images/thumbnail/" . $filename);
                }
            }

            return false;
        }

        return ["filenames" => $filenames, "sanitizedFileNames" => $sanitizedFileNames];
    }

    /**
     * @param $file
     *
     * @return bool|array
     */
    public static function UploadSingleImage($file): bool|array
    {
        $filename = "";
        try {
            /**
             * @var FileUpload $file
             */
            $ext = match ($file->getImageFileExtension()) {
                "jpeg" => "jpg",
                default => $file->getImageFileExtension(),
            };
            //Filename
            $filename = hash("sha256", $file->getTemporaryFile()) . "." . $ext;
            //File name with sanitized name
            $sanitizedFileName = $file->getSanitizedName();
            //Filename with target directory
            $filenameWDir = sprintf(
                'images/fullView/%s',
                $filename
            );

            if (!move_uploaded_file(
                $file->getTemporaryFile(),
                $filenameWDir
            )) {
                throw new RuntimeException();
            }
            ImageManager::defaultImage($filenameWDir);
            ImageManager::makeThumbnail($filenameWDir);

            return ["filename" => $filename, "sanitizedFileName" => $sanitizedFileName];
        } catch (RuntimeException) {
            @unlink("images/fullView/" . $filename);
            @unlink("images/thumbnail/" . $filename);

            return false;
        }
    }
}