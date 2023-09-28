<?php

namespace tests;

use App\Challenge\One\ChallengeOne;
use App\Services\FileService;
use PHPUnit\Framework\TestCase;

class ChallengeOneTest extends TestCase
{

    private ChallengeOne $challenge;

    protected function setUp(): void
    {
        $this->challenge = new ChallengeOne(new FileService());
    }

    public function testMinBirdsToReachWeight()
    {
        $weights = [1, 2, 5];
        $targetWeight = 11;
        $result = $this->challenge->minBirdsToReachWeight($weights, $targetWeight);
        $expectedResult = [5, 5, 1];
        $this->assertEquals(count($expectedResult), count($result));
    }

    public function testMinBirdsToReachWeightImpossible()
    {
        $weights = [5, 10];
        $targetWeight = 7;
        $result = $this->challenge->minBirdsToReachWeight($weights, $targetWeight);
        $this->assertEquals([], $result);
    }

    public function testProcessInput()
    {
        $inputData = "2\n1,2,5\n11\n1,2,3\n6";
        $result = $this->challenge->processInput($inputData);

        $expectedResult = [
            [[1, 2, 5], 11],
            [[1, 2, 3], 6]
        ];

        $this->assertEquals(count($expectedResult), count($result));
    }

}