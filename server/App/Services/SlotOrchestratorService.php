<?php 

namespace App\Services;

use App\Models\TimeSlot;

class SlotOrchestratorService {

  private function formatSlot(TimeSlot $slot): array {
    return [
      'startTime' => $slot->startTime->format('Y-m-d H:i'),
      'endTime' => $slot->endTime->format('Y-m-d H:i'),
      'employeeName' => $slot->name,
      'employeeId' => $slot->employeeId,
      'startDate' => $slot->startDate,
      'endDate' => $slot->endDate,
    ];
  }

  public function organizeSlots(array $timeSlots): array {
    usort($timeSlots, function (TimeSlot $a, TimeSlot $b) {
      return $a->startTime <=> $b->startTime;
    });

   $formattedSlots = [];
   foreach ($timeSlots as $slot) {
    $formattedSlots[] = $this->formatSlot($slot);
   }

   return $formattedSlots;
    
  }
}