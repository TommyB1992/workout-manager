<?php

namespace App\Controllers;

use App\Models\Workout;
use App\Models\WorkoutRep;
use App\Helpers\CommonHelper;
use App\Helpers\DateTimeHelper;
use App\Helpers\HtmlHelper;

class WorkoutRepController {
    public function create(): void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $workout_id = HtmlHelper::getIdInput('workout');
            $weight = HtmlHelper::getTxtInput('weight') ?: 0;
            $num_reps = HtmlHelper::getIntInput('reps');
            $rec_min = HtmlHelper::getIntInput('rec_min');
            $rec_sec = HtmlHelper::getIntInput('rec_sec');

            if (Workout::read($workout_id) === false) {
                echo 'Workout id inesistente';
                return;
            }

            if (!CommonHelper::isValidFloat($weight)) {
                echo 'Il peso non ha un valore valido';
                return;
            }

            if ($num_reps < 0 || $num_reps > 255) {
                echo 'Numero di ripetizioni non valido';
                return;
            }

            if (!DateTimeHelper::validateTime($rec_min)) {
                echo 'Valore per i minuti non valido';
                return;
            }

            if (!DateTimeHelper::validateTime($rec_sec)) {
                echo 'Valore per i secondi non valido';
                return;
            }

            WorkoutRep::create(
                $workout_id,
                (float) $weight,
                $num_reps,
                $rec_min,
                $rec_sec
            );
        }

        CommonHelper::redirectToReferer();
    }

    public function delete(int $id): void {
        if (WorkoutRep::read($id) === false) {
            echo "Ripetizione non valida.";
            return;
        }

        WorkoutRep::delete($id);
        CommonHelper::redirectToReferer();
    }
}