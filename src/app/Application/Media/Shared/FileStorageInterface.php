<?php

namespace App\Application\Media\Shared;

interface FileStorageInterface
{
    /**
     * Сохранить строковый контент в файл.
     */
    public function put(string $path, string $contents): bool;

    /**
     * Сохранить файл из локального пути (например, из /tmp/phpYg62ka).
     *
     * @param  string  $localFilePath  Абсолютный путь к файлу на сервере
     * @param  string  $targetPath  Относительный путь в хранилище (папка)
     */
    public function putFile(string $localFilePath, string $targetPath): string|false;

    /**
     * Получить контент файла в виде строки.
     */
    public function get(string $path): string;

    /**
     * Проверить существование файла.
     */
    public function exists(string $path): bool;

    /**
     * @param  string|string[]  $paths
     */
    public function delete(string|array $paths): bool;

    /**
     * Получить публичный URL-адрес файла.
     */
    public function url(string $path): string;

    /**
     * Получить поток (resource) файла для последующей отдачи пользователю.
     *
     * @return resource
     */
    public function readStream(string $path);
}
