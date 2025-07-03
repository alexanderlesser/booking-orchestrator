<?php 

use PHPUnit\Framework\TestCase;
use App\Services\TimeSlotGeneratorService;
use App\Models\Schedule;

class TimeSlotGereratorServiceTest extends TestCase {
  
  public function testGenerateSlots(): void {
    $schedule = new Schedule(
      scheduleId: 1,
      employeeId: 100,
      employeeName: 'John doe',
      startDateTime: new DateTime('2025-07-02 09:00:00'),
      endDateTime: new DateTime('2025-07-02 10:00:00'),
      breaks: [
        [
          'start' => new DateTime('2025-07-02 09:30:00'),
          'end' => new DateTime('2025-07-02 09:45:00')
        ]
        
      ]
    );

    $service = new TimeSlotGeneratorService();
    $slots = $service->generateBookableSlots($schedule);

    $this->assertCount(3, $slots);
    foreach ($slots as $slot) {
      $this->assertNotEquals('2025-07-02 09:15:00', $slot->startTime->format('H:i:s'), 'Slot at 09:15:00 should not exist');
    }
  }
}