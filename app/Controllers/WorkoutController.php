<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Exercise;
use App\Models\Muscle;
use App\Models\Workout;
use App\Models\WorkoutRep;
use App\Models\TrainingMethod;
use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\HtmlHelper;

class WorkoutController {

    public function index(string $start_date = null, int $microcycle = 7): void {
        // Mostra solo il form per scegliere la data e microciclo
        View::setGlobal([
            'start_date'    => $start_date,
            'microcycle'    => $microcycle
        ]);
        View::renderPartial('Workout/date_form');

        if ($start_date) {
            if (!DateTimeHelper::validateDate($start_date)) {
                echo "Data non valida.";
                return;
            }

            // Calcola date precedente e successiva
            $prev = DateTimeHelper::subAddDate($start_date, '-', $microcycle - 1);
            $next = DateTimeHelper::subAddDate($start_date, '+', $microcycle - 1);

            // Calcola l'elenco dei giorni da mostrare
            $dates = DateTimeHelper::getDatesRange($start_date, $microcycle);

            // Carica i dati dal model (es. workout, esercizi, etc)
            $workoutDays = $this->getWorkoutDays(
                $dates,
                Workout::getWorkoutsByDates($dates)
            );

            View::setGlobal([
                'prev'        => $prev,
                'next'        => $next,
                'workoutDays' => $workoutDays,
            ]);
            View::renderPartial('Workout/index');

            $this->showReport($dates);
        }
    }

    public function create(string $date): void {
        if (!DateTimeHelper::validateDate($date)) {
            echo "Data non valida.";
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->handleCreatePost($date);
            return;
        }

        $this->showCreateForm($date);
    }

    public function show(int $id): void {
        if (Workout::read($id) === false) {
            echo "Workout non valido.";
            return;
        }

        $reps = WorkoutRep::readByWorkoutId($id);

        View::setGlobal([
            'id'    => $id,
            'reps'  => $reps
        ]);
        View::renderPartial('Workout/exercise');
    }

    public function delete(int $id): void {
        if (Workout::read($id) === false) {
            echo 'Id inesistente';
            return;
        }

        Workout::delete($id);
        CommonHelper::redirectToReferer('/workout');
    }

    private function showReport(array $dates): void {
        $muscles = Muscle::getAllEnabled();
        $reports = Workout::getReportByDates($dates);

        $summary = [];

        foreach ($reports as $report) {
            $id = $report['id'];

            if (!isset($summary[$id])) {
                $summary[$id] = [
                    'sets'   => 0,
                    'reps'   => 0,
                    'weight' => 0,
                ];
            }

            $involvement = $this->parseInvolvement($report['involvement']);

            $summary[$id]['sets'] += 1 * $involvement;
            $summary[$id]['reps'] += $report['reps'] * $involvement;
            $summary[$id]['weight'] += $report['weight'] * $report['reps'] * $involvement;
        }

        View::setGlobal([
            'muscles' => $muscles,
            'summary' => $summary
        ]);
        View::renderPartial('Workout/report');
    }

    private function parseInvolvement(string $involvement): float {
        if (str_contains($involvement, '/')) {
            [$num, $den] = explode('/', $involvement);
            return floatval($num) / floatval($den);
        }
    
        return floatval($involvement);
    }

    private function handleCreatePost(string $date): void {
        $exercise_id = HtmlHelper::getIdInput('exercise');
        $training_id = HtmlHelper::getIdInput('training_method', false);
        $desc = HtmlHelper::getTxtInput('desc');

        if (Exercise::read($exercise_id) === false) {
            echo "Esercizio non valido.";
            return;
        }
        if ($training_id !== null && TrainingMethod::read($training_id) === false) {
            echo "Metodologia non valida.";
            return;
        }

        Workout::create($exercise_id, $training_id, $desc, $date);
        CommonHelper::redirectToReferer('/workout');
    }

    private function showCreateForm(string $date): void {
        $exercises = Exercise::getAll();
        $trainingMethods = TrainingMethod::getAll();

        View::setGlobal([
            'date'            => $date,
            'exercises'       => $exercises,
            'trainingMethods' => $trainingMethods
        ]);
        View::renderPartial('Workout/create_form');
    }

    private function getWorkoutDays(array $dates, array $workouts): array {
        $workoutDays = array_fill_keys($dates, []);

        foreach ($workouts as $workout) {
            $date = $workout['date'];
            if (isset($workoutDays[$date])) {
                $workoutDays[$date][] = $workout;
            }
        }
    
        return $workoutDays;
    }
}