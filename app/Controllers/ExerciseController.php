<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Exercise;
use App\Helpers\CommonHelper;
use App\Helpers\HtmlHelper;


class ExerciseController {

    public function index(): void {
        $exercises = Exercise::getAll();

        print_r($exercises);

        View::renderPartial('Exercise/create_form');
    }

    public function create(): void {
        $name = HtmlHelper::getNameInput();
        if (!CommonHelper::isValidName($name)) {
            exit('Nome non valido');
        }
        if (Exercise::existsByName($name)) {
            exit('Esercizio già esistente.');
        }

        Exercise::create($name);
        CommonHelper::redirectToReferer('/exercise');
    }

    public function show(int $id): void {
        $exercise = Exercise::read($id);
        if ($exercise === false) {
            exit('Esercizio non valido');
        }

        View::setGlobal($exercise);
        View::renderPartial('Exercise/update_form');
    }

    public function update(): void {
        $id = HtmlHelper::getIdInput('exercise');
        if (!Exercise::existsById($id)) {
            exit('Esercizio errato.');
        }

        $name = HtmlHelper::getNameInput();
        if (!CommonHelper::isValidName($name)) {
            exit('Nome non valido');
        }

        Exercise::update($id, $name);

        CommonHelper::redirectToReferer('/exercise/show/' . $id);

    }

    public function delete(int $id): void {
        Exercise::delete($id);
        CommonHelper::redirectToReferer('/exercise');
    }
}