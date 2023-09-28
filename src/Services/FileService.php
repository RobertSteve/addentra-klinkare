<?php

namespace App\Services;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileReadException;

class FileService
{
    /**
     * Lee el contenido de un archivo.
     *
     * @throws FileNotFoundException
     * @throws FileReadException
     */
    public function read(string $filePath): string
    {
        if (!file_exists($filePath)) {
            throw new FileNotFoundException("El archivo '$filePath' no existe.");
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new FileReadException("No se pudo leer el archivo '$filePath'.");
        }

        return $content;
    }

    /**
     * Crea un nuevo archivo o, si ya existe, lo abre para escritura.
     */
    public function create(string $filePath): void
    {
        $file = fopen($filePath, "w");
        if ($file === false) {
            throw new FileReadException("No se pudo crear o abrir el archivo '$filePath'.");
        }
        fclose($file);
    }

    /**
     * Escribe contenido en un archivo. Si el archivo ya tiene contenido, se añadirá al final.
     */
    public function write(string $filePath, string $content): void
    {
        file_put_contents($filePath, $content, FILE_APPEND);
    }
}