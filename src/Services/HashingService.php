<?php
namespace App\Services;

class HashingService
{
    public function crc32hash(array $data): string
    {
        $crc = crc32(implode(array_map("chr", $data)));
        return sprintf('%08x', $crc);
    }
}