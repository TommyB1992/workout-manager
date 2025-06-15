<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\MeasureGroup;
use App\Helpers\CommonHelper;
use App\Helpers\HtmlHelper;

class MeasureGroupController extends Controller {
    public function create(): void {
        $name = HtmlHelper::getNameInput();

        $this->validateMeasureGroup($name);

        MeasureGroup::create($name);
        CommonHelper::redirectToReferer('/measure');
    }

    public function show(int $id): void {
        $group = MeasureGroup::read($id);
        if ($group === false) {
            exit('Gruppo inesistente');
        }

        View::setGlobal($group);
        View::render('MeasureGroup/show');
    }

    public function update(): void {
        $id = HtmlHelper::getIdInput('group');
        $name = HtmlHelper::getNameInput();
    
        $group = MeasureGroup::read($id);
        
        if ($group === false) {
            exit('Gruppo inesistente');
        }

        $this->validateMeasureGroup($name, $group);
    
        MeasureGroup::update($id, $name);
        CommonHelper::redirectToReferer('/measure-group/show/'.$id);
    }

    public function delete(int $id): void {
        if (MeasureGroup::read($id) === false) {
            exit('Gruppo inesistente');
        }

        MeasureGroup::delete($id);
        CommonHelper::redirectToReferer('/measure');
    }

    private function validateMeasureGroup(string $name, ?array $existingMeasure = null): void {
        if (!CommonHelper::isValidName($name)) {
            exit('Lunghezza gruppo troppo corta');
        }
    
        $nameExists = MeasureGroup::existsByName($name);
    
        if ($existingMeasure === null && $nameExists) {
            exit('Nome gruppo già esistente');
        }
    
        if (
            $existingMeasure !== null &&
            strtolower($name) !== strtolower($existingMeasure['name']) &&
            $nameExists
        ) {
            exit('Nome gruppo già esistente');
        }
    }
}