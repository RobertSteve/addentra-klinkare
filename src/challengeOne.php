<?php

require '../vendor/autoload.php';

use App\Challenge\One\ChallengeOne;
use App\Services\FileService;

$fileProcessor = new ChallengeOne(new FileService());
$fileProcessor->processFile("Challenge/One/example.txt", "Challenge/One/example_output.txt");
$fileProcessor->processFile("Challenge/One/input.txt", "Challenge/One/output.txt");
