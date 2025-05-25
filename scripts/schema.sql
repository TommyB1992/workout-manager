CREATE TABLE `muscle` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `enabled` TINYINT NOT NULL DEFAULT '1',

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`)
);

INSERT INTO `muscle` (`name`)
     VALUES ('Chest'),
            ('Shoulders'), 
            ('Biceps'), 
            ('Triceps'), 
            ('Upper back'), 
            ('Lower back'), 
            ('Abs'), 
            ('Quads'), 
            ('Hamstrings'), 
            ('Gluteus'), 
            ('Calf');

--
-- Bicipiti/Peso/...
--
CREATE TABLE `measure_group` (
    `id` TINYINT UNSIGNED AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`)
);

CREATE TABLE `measure` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `name` VARCHAR(50) NOT NULL,
    `group_id` TINYINT UNSIGNED DEFAULT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`),
    CONSTRAINT `fk_measure_group`
        FOREIGN KEY (`group_id`) REFERENCES `measure_group` (`id`)
        ON DELETE SET NULL
);

INSERT INTO `measure` (`name`)
     VALUES ('Weight'),
            ('Chest'), 
            ('Left Bicep'), 
            ('Right Bicep'), 
            ('Abdomen'), 
            ('Gluteus'), 
            ('Leg'),
            ('Calf');

ALTER TABLE `measure`
ADD CONSTRAINT `fk_measure_group`
FOREIGN KEY (`group`) REFERENCES `measure_group`(`id`)
ON DELETE SET NULL;


--
-- Valore in cm/kg
--
CREATE TABLE `measure_value` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `measure_id` INT UNSIGNED NOT NULL,
    `value` FLOAT NOT NULL CHECK (`value` >= 0),
    `date` DATE NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_measure_date` (`measure_id`, `date`),
    CONSTRAINT `fk_measure_value_measure`
        FOREIGN KEY (`measure_id`) 
        REFERENCES `measure` (`id`) 
        ON DELETE CASCADE
);

--
-- Dip, Squat
--
CREATE TABLE `exercise` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`)
);

--
-- Bill Starr, EMOM, etc...
--
CREATE TABLE `training_method` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `description` TEXT,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`)
);

ALTER TABLE training_method ADD COLUMN js_file VARCHAR(100) DEFAULT NULL;

--
-- Esercizio/Muscolo lavorato con proporzione di quanto lo lavora (es 1x 0.5x 1/3x)
--
CREATE TABLE `muscle_worked` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `exercise_id` INT UNSIGNED NOT NULL,
    `muscle_id` INT UNSIGNED NOT NULL,
    `involvement` ENUM('1', '1/2', '1/3', '1/4') NOT NULL DEFAULT '1',

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_muscle_exercise` (`exercise_id`, `muscle_id`),
    CONSTRAINT `fk_exercise`
        FOREIGN KEY (`exercise_id`) 
        REFERENCES `exercise` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_muscle`
        FOREIGN KEY (`muscle_id`) 
        REFERENCES `muscle` (`id`) 
        ON DELETE CASCADE
);

--
-- 
--
CREATE TABLE `workout` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `exercise_id` INT UNSIGNED NOT NULL,
    `training_id` INT UNSIGNED DEFAULT NULL,
    `desc` TEXT,
    `date` DATE NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_exercise_training` (`exercise_id`, `training_id`),
    CONSTRAINT `fk_workout_exercise`
        FOREIGN KEY (`exercise_id`) 
        REFERENCES `exercise` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_training`
        FOREIGN KEY (`training_id`) 
        REFERENCES `training_method` (`id`) 
        ON DELETE SET NULL
);

CREATE TABLE `workout_rep` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `workout_id` INT UNSIGNED NOT NULL,
    `weight` FLOAT NOT NULL,
    `num` TINYINT UNSIGNED NOT NULL,
    `rec_min` TINYINT UNSIGNED NOT NULL,
    `rec_sec` TINYINT UNSIGNED NOT NULL,

    PRIMARY KEY (`id`),
    CONSTRAINT `fk_workout`
        FOREIGN KEY (`workout_id`) 
        REFERENCES `workout` (`id`) 
        ON DELETE CASCADE
);

--
-- Recupero per lo stesso esercizio
--
/*CREATE TABLE `workout_rep_rec` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `workout_id1` INT UNSIGNED NOT NULL,
    `workout_id2` INT UNSIGNED NOT NULL,
    `sec` SMALLINT UNSIGNED NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_workout` (`workout_id1`, `workout_id2`),
    CONSTRAINT `fk_workout`
        FOREIGN KEY (`workout_id1`) 
        REFERENCES `workout` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_workout`
        FOREIGN KEY (`workout_id2`) 
        REFERENCES `workout` (`id`) 
        ON DELETE CASCADE
);*/

--
-- Recupero fra esercizi, per metodiche come JS/SS
--
/*CREATE TABLE `workout_exercise_rec` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `workout_id1` INT UNSIGNED NOT NULL,
    `workout_id2` INT UNSIGNED NOT NULL,
    `sec` SMALLINT UNSIGNED NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_workout` (`workout_id1`, `workout_id2`),
    CONSTRAINT `fk_workout`
        FOREIGN KEY (`workout_id1`) 
        REFERENCES `workout` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_workout`
        FOREIGN KEY (`workout_id2`) 
        REFERENCES `workout` (`id`) 
        ON DELETE CASCADE
);*/

--
-- Bilancieri/Scarpe/Cinture per zavorrare
--
/*CREATE TABLE `equipment` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `name` INT UNSIGNED NOT NULL,
    `weight` INT UNSIGNED NOT NULL,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uk_name` (`name`)
);*/

--
-- Strumentazione da applicare agli esercizi per calcolare correttamente il peso
--
/*CREATE TABLE `exercise_equipment` (
    `id` INT UNSIGNED AUTO_INCREMENT,
    `exercise_id` INT UNSIGNED NOT NULL,
    `equipment_id` INT UNSIGNED NOT NULL,

    PRIMARY KEY (`id`),
    CONSTRAINT `fk_exercise`
        FOREIGN KEY (`exercise_id`) 
        REFERENCES `exercise` (`id`) 
        ON DELETE CASCADE,
    CONSTRAINT `fk_equipment`
        FOREIGN KEY (`equipment_id`) 
        REFERENCES `equipment` (`id`) 
        ON DELETE CASCADE
);*/
