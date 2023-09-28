<?
namespace tests;

use App\Challenge\Two\ChallengeTwo;
use App\Exceptions\FileNotFoundException;
use App\Exceptions\FileReadException;
use App\Services\FileService;
use App\Services\HashingService;
use PHPUnit\Framework\TestCase;

class ChallengeTwoTest extends TestCase
{
    private ChallengeTwo $challenge;
    private $fileServiceMock;
    private $hashingServiceMock;

    protected function setUp(): void
    {
        $this->fileServiceMock = $this->createMock(FileService::class);
        $this->hashingServiceMock = $this->createMock(HashingService::class);
        $this->challenge = new ChallengeTwo($this->fileServiceMock, $this->hashingServiceMock);
    }

    public function testParseAndHashLines()
    {
        $lines = ["sample.txt 2", "0 1", "1 2"];
        $this->hashingServiceMock->method('crc32hash')->willReturn('sampleHash');

        $reflection = new \ReflectionClass($this->challenge);
        $method = $reflection->getMethod('parseAndHashLines');
        $method->setAccessible(true);

        $result = $method->invokeArgs($this->challenge, [$lines]);

        $expectedOutput = "sample.txt 0: sampleHash\nsample.txt 1: sampleHash\nsample.txt 2: sampleHash\n";
        $this->assertEquals($expectedOutput, $result);
    }

}
