<?php 

namespace App\Services;

use App\Models\Schedule;
use App\Models\TimeSlot;
use DateTime;

class TimeSlotGeneratorService {

  private function isBreakTime(DateTime $startTime, DateTime $sessionEnd, array $breaks): bool {
    foreach ($breaks as $breakTime) {
      $breakStart = $breakTime['start'];
      $breakEnd = $breakTime['end'];

      if($startTime < $breakEnd && $sessionEnd > $breakStart) {
        return true;
      }
    }

    return false;
  }

  public function generateBookableSlots(Schedule $schedule) : array {
    $slots = [];

    $startTime = clone $schedule->startDateTime;
    $endTime = clone $schedule->endDateTime;

    while ($startTime < $endTime) {
      $sessionend = clone $startTime;
      $sessionend->modify('+15 minutes'); // Add 15 minutes to startTime (max of)

      // make sure we cannot go over endTime
      if($sessionend > $endTime) {
        break;
      }

      // Add timeslot if it's not during a break
      if(!$this->isBreakTime($startTime, $sessionend, $schedule->breaks)) {
        $slots[] = new TimeSlot(
          clone $startTime,
          clone $sessionend,
          $schedule->startDateTime->format('Y-m-d'),
          $schedule->endDateTime->format('Y-m-d'),
          $schedule->employeeId,
          $schedule->employeeName
        );
      }

      $startTime = $sessionend;

    }

    return $slots;
  }

}

?>