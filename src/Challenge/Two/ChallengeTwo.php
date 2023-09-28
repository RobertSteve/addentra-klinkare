<?php

namespace App\Challenge\Two;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileReadException;
use App\Services\FileService;
use App\Services\HashingService;

class ChallengeTwo
{
    public function __construct(
        private FileService $fileService,
        private HashingService $hashingService
    ) {}


    public function processFile(string $inputPath, string $outputPath): void
    {
        try {
            $fileContents = $this->fileService->read($inputPath);
            $lines = explode("\n", trim($fileContents));
            $this->fileService->create($outputPath);
            $outputData = $this->parseAndHashLines($lines);
            $this->fileService->write($outputPath, $outputData);
        } catch (FileNotFoundException | FileReadException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    private function parseAndHashLines(array $lines): string
    {
        $lineIndex = 0;
        $outputData = "";
        $blockCount = 0;

        while ($lineIndex < count($lines)) {
            $currentLine = $lines[$lineIndex];
            [$filenameOrByte, $interactionsOrPosition] = explode(" ", $currentLine);
            $interactionsOrPosition = (int)$interactionsOrPosition;
            $currentByteGroup = [];

            if (!is_numeric($filenameOrByte)) {
                $interactionIndex = 0;
                $lineIndex++;
                $currentByteGroup[0] = $blockCount === 0 ? [] : [0];
                $outputData .= "$filenameOrByte $interactionIndex: ". $this->hashingService->crc32hash($currentByteGroup[0]) . PHP_EOL;
                $blockCount++;
            }

            for ($i = 0; $i < $interactionsOrPosition; $i++) {
                $flattenedBytes = [];
                [$position, $byte] = explode(" ", $lines[$lineIndex + $i]);
                $currentByteGroup[$position][] = (int)$byte;

                sort($currentByteGroup[$position]);

                if (in_array(0, $currentByteGroup[$position])) {
                    $currentByteGroup[$position] = array_filter($currentByteGroup[$position], function($value) {
                        return $value !== 0;
                    });
                    $currentByteGroup[$position][] = 0;
                }

                foreach ($currentByteGroup as $bytes) {
                    foreach ($bytes as $byteValue) {
                        $flattenedBytes[] = $byteValue;
                    }
                }
                $position = $i + 1;
                $outputData .= "$filenameOrByte $position: " . $this->hashingService->crc32hash($flattenedBytes) . PHP_EOL;
            }

            $lineIndex += $interactionsOrPosition;
        }

        return $outputData;
    }
}
