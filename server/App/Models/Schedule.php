<?php 

namespace App\Models;

class Schedule {
    public int $scheduleId;
    public int $employeeId;
    public string $employeeName;
    public \DateTime $startDateTime;
    public \DateTime $endDateTime;
    public array $breaks = [];

    public function __construct(
        int $scheduleId,
        int $employeeId,
        string $employeeName,
        \DateTime $startDateTime,
        \DateTime $endDateTime,
        array $breaks = []
    ) {
        $this->scheduleId = $scheduleId;
        $this->employeeId = $employeeId;
        $this->employeeName = $employeeName;
        $this->startDateTime = $startDateTime;
        $this->endDateTime = $endDateTime;
        $this->breaks = $breaks;
    }

  public function getBreaks(): array {
      return $this->breaks;
  }
}