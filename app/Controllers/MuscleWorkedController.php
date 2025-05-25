<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Exercise;
use App\Models\Muscle;
use App\Models\MuscleWorked;
use App\Helpers\CommonHelper;
use App\Helpers\HtmlHelper;


class MuscleWorkedController {
    private const array INVOLVEMENT = ['1', '1/2', '1/3', '1/4'];

    public function index(): void {
        $musclesWorked = MuscleWorked::getAll();
        $muscles = Muscle::getAll();
        $exercises = Exercise::getAll();

        print_r($musclesWorked);

        View::setGlobal([
            'muscles'   => $muscles,
            'exercises' => $exercises,
        ]);
        View::renderPartial('MuscleWorked/create');
    }

    public function create(): void {
        $exercise_id = HtmlHelper::getIdInput('exercise');
        $muscle_id = HtmlHelper::getIdInput('muscle');
        $involvement = $_POST['involvement'] ?? null;

        if (!Exercise::existsById($exercise_id)) {
            exit('Esercizio errato');
        }

        if (!Muscle::existsById($muscle_id)) {
            exit('Esercizio errato');
        }

        if (MuscleWorked::exists($exercise_id, $muscle_id)) {
            exit('Esrcizio/Muscolo già inserito');
        }

        if (!in_array($involvement, self::INVOLVEMENT)) {
            exit('Coinvolgimento errato');
        }

        MuscleWorked::create($exercise_id, $muscle_id, $involvement);
        CommonHelper::redirectToReferer('/muscle-worked');
    }

    public function delete(int $id): void {
        MuscleWorked::delete($id);
        CommonHelper::redirectToReferer('/muscle-worked');
    }
}