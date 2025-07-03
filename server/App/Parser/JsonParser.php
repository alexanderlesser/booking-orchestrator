<?php 
namespace App\Parser;

use App\Models\Schedule;
use DateTime;



class JsonParser {
  private array $rawData;

  public function __construct(array $rawData) {
    $this->rawData = $rawData;
  }

  private function parseScheduleItem(array $item): Schedule {
    $swedishTimeZone = new \DateTimeZone('Europe/Stockholm'); // most likley in Europe/Stockholm timezone.
    $startDateTime = new DateTime($item['startDate'] . ' ' . $item['startTime'], $swedishTimeZone);
    $endDateTime = new DateTime($item['endDate'] . ' ' . $item['endTime'], $swedishTimeZone);
    $breaks = $this->parseBreaks($item, $item['startDate']);

    return new Schedule(
        $item['scheduleId'],
        $item['employeeId'],
        $item['employeeName'],
        $startDateTime,
        $endDateTime,
        $breaks
    );
  }

  private function parseBreaks(array $item, string $date): array {
      $breaks = [];
      $swedishTimeZone = new \DateTimeZone('Europe/Stockholm');
      for ($i = 1; $i <= 4; $i++) {
        $startKey = 'startBreak' . ($i === 1 ? '' : $i);
        $endKey = 'endBreak' . ($i === 1 ? '' : $i);
        $start = $item[$startKey] ?? '00:00:00';
        $end = $item[$endKey] ?? '00:00:00';

        if($start !== '00:00:00' || $end !== '00:00:00') {
          $breaks[] = [
            'start' => new DateTime($date . ' ' . $start, $swedishTimeZone),
            'end' => new DateTime($date . ' ' . $end, $swedishTimeZone),
          ];
        }
      
      }
      return $breaks;
  }

  public function parseSchedules(): array {
    $schedules = [];

    foreach ($this->rawData as $item) {
      $schedules[] = $this->parseScheduleItem($item);
    }

    return $schedules;
  }
}

?>