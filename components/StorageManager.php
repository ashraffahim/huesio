<?php

namespace app\components;

use app\models\exceptions\common\CannotUploadFileException;
use app\models\exceptions\common\FileDoesNotExistException;
use yii\helpers\FileHelper;

class StorageManager {
    private const STORAGE_ROOT = __DIR__ . '/../../huesio_storage/';

    private const BLOG_CONTENT = 'blog_content/';

    public const READER_BUFFER_LENGTH = 512;

    /**
     * Upload file to storage
     * @param string|resource|StreamInterface|null $content
     * @param string $name
     * @throws CannotUploadFileException
     */
    public static function uploadFile($content, string $name) {
        $file = fopen(self::STORAGE_ROOT . $name, 'w');

        if ($file === false) throw new CannotUploadFileException();
        
        while (!feof($content)) {
            if (fwrite($file, fread($content, 512)) === false) throw new CannotUploadFileException();
        }

        if (fclose($file) === false) throw new CannotUploadFileException();
    }

    /**
     * Upload content as file to storage
     * @param string|resource|StreamInterface|null $content
     * @param string $name
     * @throws CannotUploadFileException
     */
    public static function uploadFileContent($content, string $name) {
        $file = fopen(self::STORAGE_ROOT . $name, 'w');

        if ($file === false) throw new CannotUploadFileException();
        
        if (fwrite($file, $content) === false) throw new CannotUploadFileException();

        if (fclose($file) === false) throw new CannotUploadFileException();
    }

    /**
     * Get file resource
     * @param string $name
     * @return bool
     */
    public static function fileExists(string $name) {
        return file_exists(self::STORAGE_ROOT . $name);
    }

    /**
     * Get file resource
     * @param string $name
     * @return resource
     * @throws FileDoesNotExistException
     */
    public static function getFileResource(string $name) {
        $file = fopen(self::STORAGE_ROOT . $name, 'r');

        if ($file === false) {
            throw new FileDoesNotExistException();
        }

        return $file;
    }

    /**
     * Close resource
     * @param resource $stream
     * @return resource|false
     */
    public static function closeFile($stream) {
        return fclose($stream);
    }

    /**
     * Create directories if does not exist
     * @param string $paths
     */
    private static function createDirsIfDoesNotExist(string $path) {
        if (!is_dir($path)) {
            FileHelper::createDirectory(self::STORAGE_ROOT . $path, 0777, true);
        }
    }

    /**
     * Get blog content file path
     * @param string $uuid
     * @return string
     */
    public static function getBlogContentFilePath(string $uuid) {
        $path = self::BLOG_CONTENT . $uuid;
        self::createDirsIfDoesNotExist($path);
        $path .= '/blog.html';

        return $path;
    }

    /**
     * Upload blog html file to storage
     * @param string $uuid
     * @throws CannotUploadFileException
     */
    public static function uploadBlogContent(string $content, string $uuid) {
        $path = self::getBlogContentFilePath($uuid);

        self::uploadFileContent($content, $path);
    }
}

?>