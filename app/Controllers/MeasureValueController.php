<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Measure;
use App\Models\MeasureValue;
use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\HtmlHelper;

class MeasureValueController {
    public function index(): void {
        $measures = Measure::getAll();

        View::setGlobal(['measures' => $measures]);
        View::renderPartial('MeasureValue/search_form');
        View::renderPartial('MeasureValue/create_form');
    }

    public function create(): void {
        $measure_id = HtmlHelper::getIdInput('measure');
        $date = HtmlHelper::getTxtInput('date');
        $value = HtmlHelper::getTxtInput('value');

        if (!MeasureValue::existsById($measure_id)) {
            exit('Valore inesistente');
        }

        if (!DateTimeHelper::validateDate($date)) {
            exit('Data non valida.');
        }

        if (!CommonHelper::isValidFloat($value)) {
            exit("Valore non valido.");
        }

        MeasureValue::create($measure_id, $value, $date);
        CommonHelper::redirectToReferer('/measure-value');
    }

    public function delete(int $id): void {
        if (!MeasureValue::exists($id)) {
            exit('Valore inesistente');
        }
    
        MeasureValue::delete($id);
        CommonHelper::redirectToReferer('/measure-value');
    }

    public function search(): void {
        $rawData = json_decode(file_get_contents('php://input'), true);
        $measureIds = $rawData['show_by_measure'] ?? [];
        if (!is_array($measureIds)) {
            $measureIds = [$measureIds];
        }
        $startDate = $rawData['start_date'] ?? null;
        $endDate = $rawData['end_date'] ?? null;
        $exactDate = $rawData['show_by_date'] ?? null;
        $groupBy = $rawData['by'] ?? 'day';

        $hasStartDate = !empty($startDate);
        $hasEndDate = !empty($endDate);
        $hasExactDate = !empty($exactDate);

        $startDateValid = $hasStartDate && DateTimeHelper::validateDate($startDate);
        $endDateValid = $hasEndDate && DateTimeHelper::validateDate($endDate);
        $rangeDateValid = $hasStartDate && $hasEndDate && DateTimeHelper::isDateLessThan($startDate, $endDate);
        $exactDateValid = $exactDate && DateTimeHelper::validateDate($exactDate);

        $valid = (!$hasStartDate && !$hasEndDate && !$hasExactDate) // Nessuna data fornita
            || ($exactDateValid && !$hasStartDate && !$hasEndDate) // Solo exact date
            || ($rangeDateValid && !$hasExactDate); // Solo range valido
        if (!$valid) {
            exit('Data non valida.');
        }

        $measures = array_keys(Measure::getAll());
        foreach ($measureIds as $measureId) {
            if (!in_array($measureId, $measures)) {
                exit('Misura non valida.');
            }
        }

        $filters = [
            'by' => $groupBy,
            'show_by_measure' => $measureIds,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'show_by_date' => $exactDate
        ];

        $data = MeasureValue::filter($filters);

        header('Content-Type: application/json');
        echo json_encode([
            'status' => 'ok',
            'data' => $data
        ]);
    }
}