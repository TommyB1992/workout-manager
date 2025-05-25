<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Measure;
use App\Models\MeasureGroup;
use App\Helpers\CommonHelper;
use App\Helpers\HtmlHelper;

class MeasureController {
    public function index(): void {
        $measures = Measure::getAll();
        $groups = MeasureGroup::getAll();

        View::setGlobal([
            'measures' => $measures,
            'groups'   => $groups,
        ]);
        View::renderPartial('Measure/index');
    }

    public function create(): void {
        $name = HtmlHelper::getNameInput();
        $group_id = HtmlHelper::getIdInput('group', false);
    
        $this->validateMeasure($name, $group_id);
    
        Measure::create($name, $group_id);
        CommonHelper::redirectToReferer('/measure');
    }

    public function show(int $id): void {
        $measure = Measure::read($id);
        if ($measure === false) {
            exit('Misura inesistente');
        }

        View::setGlobal([
            'measure'   => $measure,
            'groups'    => MeasureGroup::getAll(),
        ]);
        View::renderPartial('Measure/show');
    }

    public function update(): void {
        $id = HtmlHelper::getIdInput('measure');
        $name = HtmlHelper::getNameInput();
        $group_id = HtmlHelper::getIdInput('group', false);
    
        $measure = Measure::read($id);
        if ($measure === false) {
            exit('Misura inesistente');
        }
    
        $this->validateMeasure($name, $group_id, $measure);
    
        Measure::update($id, $name, $group_id);
        CommonHelper::redirectToReferer('/measure/show/' . $id);
    }

    public function delete(int $id): void {
        if (Measure::read($id) === false) {
            exit('Misura inesistente');
        }

        Measure::delete($id);
        CommonHelper::redirectToReferer('/measure');
    }

    private function validateMeasure(
        string  $name,
        ?int    $group_id,
        ?array  $existingMeasure = null
    ): void {
        if (CommonHelper::isValidName($name)) {
            exit('Lunghezza misura troppo corta');
        }
    
        $nameExists = Measure::existsByName($name);
    
        if ($existingMeasure === null && $nameExists) {
            exit('Nome misura già esistente');
        }
    
        if (
            $existingMeasure !== null &&
            strtolower($name) !== strtolower($existingMeasure['name']) &&
            $nameExists
        ) {
            exit('Nome misura già esistente');
        }
    
        if ($group_id !== null && MeasureGroup::read($group_id) === false) {
            exit('Gruppo inesistente');
        }
    }
}