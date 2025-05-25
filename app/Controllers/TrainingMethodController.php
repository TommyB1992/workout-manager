<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\TrainingMethod;
use App\Helpers\CommonHelper;
use App\Helpers\HtmlHelper;


class TrainingMethodController {

    public function index(): void {
        $trainingMethods = TrainingMethod::getAll();
        print_r($trainingMethods);
        $js_files = $this->getJSlibs();

        View::setGlobal(['js_files' => $js_files]);
        View::renderPartial('TrainingMethod/create_form');
    }

    public function create(): void {
        $name = HtmlHelper::getNameInput();
        $desc = HtmlHelper::getTxtInput('desc');
        $js_file = $_POST['js_file'] ?? null;

        if (TrainingMethod::existsByName($name)) {
            exit('Metodo già esistente.');
        }

        $this->validateTrainingMethod($name, $js_file);

        TrainingMethod::create($name, $desc, $js_file);
        CommonHelper::redirectToReferer('/training-method');
    }

    public function show(int $id): void {
        $trainingMethod = TrainingMethod::read($id);
        if ($trainingMethod === false) {
            exit('Metodo non valido');
        }

        print_r($trainingMethod);
        $js_files = $this->getJSlibs();

        View::setGlobal([
            'trainingMethod' => $trainingMethod,
            'js_files'       => $js_files
        ]);
        View::renderPartial('TrainingMethod/update_form');
    }

    public function update(): void {
        $id = HtmlHelper::getIdInput('training_method');
        $name = HtmlHelper::getNameInput();
        $desc = HtmlHelper::getTxtInput('desc');
        $js_file = $_POST['js_file'] ?? null;

        if (!TrainingMethod::existsById($id)) {
            exit('Metodo errato.');
        }

        $this->validateTrainingMethod($name, $js_file);

        TrainingMethod::update($id, $name, $desc, $js_file);
        CommonHelper::redirectToReferer('/training-method/show/' . $id);

    }

    public function delete(int $id): void {
        TrainingMethod::delete($id);
        CommonHelper::redirectToReferer('/training-method');
    }

    private function validateTrainingMethod(string $name, ?string $js_file): void {
        if (!CommonHelper::isValidName($name)) {
            exit('Nome non valido');
        }

        if (!isset($js_file) && !in_array($js_file, $this->getJSlibs())) {
            exit('Il file non esiste');
        }
    }

    private function getJSlibs(): array {
        $files = glob(__DIR__ . '/../../public/js/training-methods/*.js') ?: [];
        return array_map('basename', $files);
    }
}