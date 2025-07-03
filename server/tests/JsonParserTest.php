<?php

namespace Tests\Parser;

use PHPUnit\Framework\TestCase;
use App\Parser\JsonParser;

class JsonParserTest extends TestCase {
    public function testParseSchedulesCreatesSchedules()
    {
        $rawData = [
            [
                'scheduleId' => 1,
                'employeeId' => 100,
                'employeeName' => 'John Doe',
                'startDate' => '2025-07-02',
                'startTime' => '08:00:00',
                'endDate' => '2025-07-02',
                'endTime' => '10:00:00',
                'startBreak' => '09:00:00',
                'endBreak' => '09:30:00',
            ]
        ];

        $parser = new JsonParser($rawData);
        $schedules = $parser->parseSchedules();

        $schedule = $schedules[0];
        $this->assertEquals(1, $schedule->scheduleId);
        $this->assertEquals(100, $schedule->employeeId);
        $this->assertEquals('John Doe', $schedule->employeeName);

        // Should be one break in break array
        $this->assertCount(1, $schedule->breaks);
    }
}
