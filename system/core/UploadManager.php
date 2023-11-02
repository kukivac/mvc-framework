<?php

namespace system\core;

use Nette\Http\FileUpload as FileUpload;
use RuntimeException;

class UploadManager
{
    /**
     * @param FileUpload[] $values
     *
     * @return bool|string[][]
     */
    public static function UploadMultipleImages(array $values)
    {
        $filenames = [];
        $sanitizedFileNames = [];
        try {
            foreach ($values as $file) {
                $fileExtension = $file->getImageFileExtension();
                switch ($fileExtension) {
                    case "jpeg":
                        $ext = "jpg";
                        break;
                    default:
                        $ext = $fileExtension;
                        break;
                }

                //Filename with extension
                $filenames[] = ($filename = hash("sha256", $file->getTemporaryFile()) . "." . $ext);
                //File name with sanitized name
                $sanitizedFileNames[] = $file->getSanitizedName();
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
        } catch (RuntimeException $exception) {
            if (count($filenames) !== 0) {
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
     * @param FileUpload $file
     *
     * @return bool|string[]
     */
    public static function UploadSingleImage(FileUpload $file)
    {
        $filename = "";
        try {
            $fileExtension = $file->getImageFileExtension();
            switch ($fileExtension) {
                case "jpeg":
                    $ext = "jpg";
                    break;
                default:
                    $ext = $fileExtension;
                    break;
            }

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
        } catch (RuntimeException $exception) {
            @unlink("images/fullView/" . $filename);
            @unlink("images/thumbnail/" . $filename);

            return false;
        }
    }
}