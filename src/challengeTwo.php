<?php

require '../vendor/autoload.php';

use App\Challenge\Two\ChallengeTwo;
use App\Services\FileService;
use App\Services\HashingService;

$fileProcessor = new ChallengeTwo(new FileService(), new HashingService());
$fileProcessor->processFile("Challenge/Two/example.txt", "Challenge/Two/example_output.txt");
$fileProcessor->processFile("Challenge/Two/input.txt", "Challenge/Two/output.txt");