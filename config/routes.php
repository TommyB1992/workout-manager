<?php

use App\Controllers\WorkoutController;
use App\Controllers\WorkoutRepController;
use App\Controllers\MeasureController;
use App\Controllers\MeasureGroupController;
use App\Controllers\MeasureValueController;
use App\Controllers\MuscleController;
use App\Controllers\MuscleWorkedController;
use App\Controllers\ExerciseController;
use App\Controllers\TrainingMethodController;

return [
    // WorkoutController
    ['GET',  '/workout',                            [WorkoutController::class, 'index']],               
    ['GET',  '/workout/create/{date}',              [WorkoutController::class, 'create']],              
    ['POST', '/workout/create/{date}',              [WorkoutController::class, 'create']],              
    ['GET',  '/workout/show/{id}',                  [WorkoutController::class, 'show']],                
    ['GET',  '/workout/delete/{id}',                [WorkoutController::class, 'delete']],              
    ['GET',  '/workout/{start_date}/{microcycle}',  [WorkoutController::class, 'index']],               

    // WorkoutRepController
    ['POST', '/workout-rep/create',                 [WorkoutRepController::class, 'create']],           
    ['GET',  '/workout-rep/delete/{id}',            [WorkoutRepController::class, 'delete']],           

    // MeasureController
    ['GET',  '/measure',                            [MeasureController::class, 'index']],               
    ['POST', '/measure/create',                     [MeasureController::class, 'create']],              
    ['GET',  '/measure/show/{id}',                  [MeasureController::class, 'show']],                
    ['POST', '/measure/update',                     [MeasureController::class, 'update']],              
    ['GET',  '/measure/delete/{id}',                [MeasureController::class, 'delete']],              

    // MeasureGroupController
    ['POST', '/measure-group/create',               [MeasureGroupController::class, 'create']],         
    ['GET',  '/measure-group/show/{id}',            [MeasureGroupController::class, 'show']],           
    ['POST', '/measure-group/update',               [MeasureGroupController::class, 'update']],         
    ['GET',  '/measure-group/delete/{id}',          [MeasureGroupController::class, 'delete']],         

    // MeasureValueController
    ['GET',  '/measure-value',                      [MeasureValueController::class, 'index']],
    ['POST', '/measure-value/create',               [MeasureValueController::class, 'create']],          
    ['GET',  '/measure-value/delete/{id}',          [MeasureValueController::class, 'delete']],          
    ['POST', '/measure-value/search',               [MeasureValueController::class, 'search']],          

    // MuscleController
    ['GET',  '/muscle',                             [MuscleController::class, 'index']],                 
    ['POST', '/muscle/create',                      [MuscleController::class, 'create']],                
    ['GET',  '/muscle/show/{id}',                   [MuscleController::class, 'show']],                  
    ['POST', '/muscle/update',                      [MuscleController::class, 'update']],                
    ['GET',  '/muscle/delete/{id}',                 [MuscleController::class, 'delete']],                

    // MuscleWorkedController
    ['GET',  '/muscle-worked',                      [MuscleWorkedController::class, 'index']],           
    ['POST', '/muscle-worked/create',               [MuscleWorkedController::class, 'create']],          
    ['GET',  '/muscle-worked/delete/{id}',          [MuscleWorkedController::class, 'delete']],          

    // ExerciseController
    ['GET',  '/exercise',                           [ExerciseController::class, 'index']],               
    ['POST', '/exercise/create',                    [ExerciseController::class, 'create']],              
    ['GET',  '/exercise/show/{id}',                 [ExerciseController::class, 'show']],                
    ['POST', '/exercise/update',                    [ExerciseController::class, 'update']],              
    ['GET',  '/exercise/delete/{id}',               [ExerciseController::class, 'delete']],              

    // TrainingMethodController
    ['GET',  '/training-method',                    [TrainingMethodController::class, 'index']],         
    ['POST', '/training-method/create',             [TrainingMethodController::class, 'create']],        
    ['GET',  '/training-method/show/{id}',          [TrainingMethodController::class, 'show']],          
    ['POST', '/training-method/update',             [TrainingMethodController::class, 'update']],        
    ['GET',  '/training-method/delete/{id}',        [TrainingMethodController::class, 'delete']],        
];
