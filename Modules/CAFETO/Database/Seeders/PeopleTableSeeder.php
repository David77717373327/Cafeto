<?php

namespace Modules\CAFETO\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\SICA\Entities\EPS;
use Modules\SICA\Entities\PensionEntity;
use Modules\SICA\Entities\Person;
use Modules\SICA\Entities\PopulationGroup;

class PeopleTableSeeder extends Seeder
{
    public function run()
    {
        $population_group = PopulationGroup::firstOrCreate(['name' => 'NINGUNA']);
        $eps = EPS::firstOrCreate(['name' => 'NO REGISTRA']);
        $pension_entity = PensionEntity::firstOrCreate(['name' => 'NO REGISTRA']);

        // Consulta o registro de datos para Lola Fernanda Herrera Hernandez (Líder de Estación de Café)
        Person::firstOrCreate(['document_number' => 52829681], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'LOLA FERNANDA',
            'first_last_name' => 'HERRERA',
            'second_last_name' => 'HERNANDEZ',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Estación de Café
        Person::firstOrCreate(['document_number' => 987654321], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'ESTACIÓN DE',
            'first_last_name' => 'CAFÉ',
            'second_last_name' => '',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Vilmer Andres Mendez Murcia (Líder de agroindustria)
        Person::firstOrCreate(['document_number' => 7723876], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'VILMER ANDRES',
            'first_last_name' => 'MENDEZ',
            'second_last_name' => 'MURCIA',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Manuel Steven Ossa Lievano (Cajero de Estación de Café)
        Person::firstOrCreate(['document_number' => 1000226706], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'MANUEL STEVEN',
            'first_last_name' => 'OSSA',
            'second_last_name' => 'LIEVANO',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Jesús David Guevara Munar (Superadministrador)
        Person::firstOrCreate(['document_number' => 1004494010], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'JESÚS DAVID',
            'first_last_name' => 'GUEVARA',
            'second_last_name' => 'MUNAR',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Julian Javier Ramirez Díaz
        Person::firstOrCreate(['document_number' => 1083874040], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'JULIAN JAVIER',
            'first_last_name' => 'RAMIREZ',
            'second_last_name' => 'DÍAZ',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Jesús David Quizá Roa (Instructor)
        Person::firstOrCreate(['document_number' => 1077224582], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'JESÚS DAVID ',
            'first_last_name' => 'QUIZÁ',
            'second_last_name' => '',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);

        // Consulta o registro de datos para Eliana Sofia Ascencio (Cajero Pasante)
        Person::firstOrCreate(['document_number' => 1080931780], [
            'document_type' => 'Cédula de ciudadanía',
            'first_name' => 'ELIANA',
            'first_last_name' => 'ASCENCIO',
            'second_last_name' => '',
            'eps_id' => $eps->id,
            'population_group_id' => $population_group->id,
            'pension_entity_id' => $pension_entity->id
        ]);
    }
}