<?php

namespace App\Challenge\One;

use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileReadException;
use App\Services\FileService;

ini_set('memory_limit', '3G');

class ChallengeOne
{
    public function __construct(
        private FileService $fileService,
    ) {}

    public function processFile(string $inputPath, string $outputPath): void
    {
        try {
            $fileContents = $this->fileService->read($inputPath);
            $outputData = $this->run($fileContents);
            $this->fileService->create($outputPath);
            $this->fileService->write($outputPath, $outputData);
        } catch (FileNotFoundException | FileReadException $e) {
            echo $e->getMessage() . PHP_EOL;
        }
    }

    private function run(string $inputData): string
    {
        $cases = $this->processInput($inputData);
        $results = [];

        foreach ($cases as [$weights, $targetWeight]) {
            $birdsUsed = $this->minBirdsToReachWeight($weights, $targetWeight);
            $results[] = empty($birdsUsed) ?
                "Imposible" :
                count($birdsUsed) . ":" . implode(',', $birdsUsed);
        }

        return implode("\n", $results);
    }

    public function processInput(string $inputData): array
    {
        $lines = explode("\n", trim($inputData));
        $numCases = (int)$lines[0];
        $cases = [];

        for ($i = 0; $i < $numCases; $i++) {
            $weights = array_map('intval', explode(',', $lines[$i * 2 + 1]));
            $targetWeight = (int)$lines[$i * 2 + 2];
            $cases[] = [$weights, $targetWeight];
        }

        return $cases;
    }

    public function minBirdsToReachWeight(array $weights, int $targetWeight): array
    {
        $dp = array_fill(0, $targetWeight + 1, INF);
        $dp[0] = 0;

        for ($i = 1; $i <= $targetWeight; $i++) {
            foreach ($weights as $weight) {
                if ($i >= $weight) {
                    $dp[$i] = min($dp[$i], $dp[$i - $weight] + 1);
                }
            }
        }

        if ($dp[$targetWeight] === INF) {
            return [];
        }

        $result = [];
        while ($targetWeight > 0) {
            foreach ($weights as $weight) {
                if ($targetWeight - $weight >= 0 && $dp[$targetWeight - $weight] === $dp[$targetWeight] - 1) {
                    $result[] = $weight;
                    $targetWeight -= $weight;
                    break;
                }
            }
        }
        return $result;
    }
}