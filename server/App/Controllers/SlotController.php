<?php 
namespace App\Controllers;

use App\Helpers\JSONReader;
use App\Parser\JsonParser;
use App\Services\TimeSlotGeneratorService;
use App\Services\SlotOrchestratorService;
use Exception;

class SlotController {

  private string $jsonPath = __DIR__ . '/../../data/data.json';

  public function index(): void {
    header('Content-Type: application/json');

    try {
      $jsonReader = new JSONReader();

      $rawData = $jsonReader->read($this->jsonPath);

      $jsonParser = new JsonParser($rawData);

      $schedules = $jsonParser->parseSchedules();

      $timeSlotGenerator = new TimeSlotGeneratorService();

      $slots = [];

      foreach ($schedules as $schedule) {
        $generatedSlots = $timeSlotGenerator->generateBookableSlots($schedule);
        $slots = array_merge($slots, $generatedSlots);
      }

      $orchestrator = new SlotOrchestratorService();
      $formattedSlots = $orchestrator->organizeSlots($slots);

      $responseData = [
        'message' => 'success',
        'data' => $formattedSlots,
      ];

      echo json_encode($responseData, JSON_PRETTY_PRINT);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'error' => 'Internal Server Error',
            'message' => $e->getMessage()
        ], JSON_PRETTY_PRINT);
    }
  }
}