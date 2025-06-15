<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Muscle;
use App\Helpers\CommonHelper;
use App\Helpers\HtmlHelper;


class MuscleController extends Controller {
    public function index(): void {
        $muscles = Muscle::getAll();
        View::render('Muscle/index', [
            'muscles' => $muscles
        ]);
    }

    public function create(): void {
        $name = HtmlHelper::getNameInput();
        
        if (!CommonHelper::isValidName($name)) {
            exit('Nome non valido');
        }

        if (Muscle::existsByName($name)) {
            exit('Nome già presente');
        }

        Muscle::create(
            $name,
            (int) isset($_POST['enabled'])
        );

        CommonHelper::redirectToReferer('/muscle');
    }

    public function show(int $id): void {
        $muscle = Muscle::read($id);
        if ($muscle === false) {
            exit('Muscolo non valido');
        }

        View::setGlobal($muscle);
        View::render('Muscle/show');
    }

    public function update(): void {
        $id = HtmlHelper::getIdInput('muscle');
        $name = HtmlHelper::getNameInput();

        if (!Muscle::existsById($id)) {
            exit('Muscolo non valido');
        }

        if (!CommonHelper::isValidName($name)) {
            exit('Nome non valido');
        }

        Muscle::update(
            $id,
            $name,
            (int) isset($_POST['enabled'])
        );

        CommonHelper::redirectToReferer('/muscle/show/' . $id);
    }

    public function delete(int $id): void {
        Muscle::delete($id);
        CommonHelper::redirectToReferer('/muscle');
    }
}