<?php 
namespace App\Models;

use DateTime;

class TimeSlot {
  public DateTime $startTime;
  public DateTime $endTime;
  public string $startDate;
  public string $endDate;
  public string $name;
  public int $employeeId;

  public function __construct(DateTime $startTime, DateTime $endTime, string $startDate, string $endDate, int $employeeId, string $name) {
    $this->startTime = $startTime;
    $this->endTime = $endTime;
    $this->startDate = $startDate;
    $this->endDate = $endDate;
    $this->employeeId = $employeeId;
    $this->name = $name;
  }

  public function toArray(): array {
    return [
    'start' => $this->startTime->format('Y-m-d H:i'),
    'end' => $this->endTime->format('Y-m-d H:i'),
    'name' => $this->name,
    'startDate' => $this->startDate,
    'endDate' => $this->endDate,
    'employeeId' => $this->employeeId,
    ];
  }
}