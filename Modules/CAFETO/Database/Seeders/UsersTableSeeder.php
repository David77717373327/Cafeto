<?php

namespace Modules\CAFETO\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\SICA\Entities\Person;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Registrar o actualizar usuario para Lola Fernanda Herrera Hernandez
        $person = Person::where('document_number', 52829681)->first();
        if ($person) {
            $existingUser = User::where('person_id', $person->id)->first();
            if ($existingUser) {
                $existingUser->update([
                    'nickname' => 'LFHerre',
                    'email' => 'lolafernandaherrera@gmail.com',
                    'password' => $existingUser->password ?? bcrypt('password')
                ]);
            } else {
                User::updateOrCreate(['nickname' => 'LFHerre'], [
                    'person_id' => $person->id,
                    'email' => 'lolafernandaherrera@gmail.com',
                    'password' => bcrypt('password')
                ]);
            }
        }

        // Registrar o actualizar usuario para Manuel Steven Ossa Lievano
        $person = Person::where('document_number', 1000226706)->first();
        if ($person) {
            $existingUser = User::where('person_id', $person->id)->first();
            if ($existingUser) {
                $existingUser->update([
                    'nickname' => 'Resmerveilons',
                    'email' => 'manuelstevenossa@gmail.com',
                    'password' => $existingUser->password ?? bcrypt('password')
                ]);
            } else {
                User::updateOrCreate(['nickname' => 'Resmerveilons'], [
                    'person_id' => $person->id,
                    'email' => 'manuelstevenossa@gmail.com',
                    'password' => bcrypt('password')
                ]);
            }
        }

        // Registrar o actualizar usuario para Jesús David Guevara Munar
        $person = Person::where('document_number', 1004494010)->first();
        if ($person) {
            $existingUser = User::where('person_id', $person->id)->first();
            if ($existingUser) {
                $existingUser->update([
                    'nickname' => 'JDGM0331',
                    'email' => 'jdguevara01@soy.sena.edu.co',
                    'password' => $existingUser->password ?? bcrypt('password')
                ]);
            } else {
                User::updateOrCreate(['nickname' => 'JDGM0331'], [
                    'person_id' => $person->id,
                    'email' => 'jdguevara01@soy.sena.edu.co',
                    'password' => bcrypt('password')
                ]);
            }
        }

        // Registrar o actualizar usuario para Jesús David Quizá Roa
        $person = Person::where('document_number', 1077224582)->first();
        if ($person) {
            $existingUser = User::where('person_id', $person->id)->first();
            if ($existingUser) {
                $existingUser->update([
                    'nickname' => 'InstructorJesu',
                    'email' => 'jesusquiza@gmail.com',
                    'password' => $existingUser->password ?? bcrypt('password')
                ]);
            } else {
                User::updateOrCreate(['nickname' => 'InstructorJesu'], [
                    'person_id' => $person->id,
                    'email' => 'jesusquiza@gmail.com',
                    'password' => bcrypt('password')
                ]);
            }
        }

        // Registrar o actualizar usuario para Eliana Sofia Ascencio
        $person = Person::where('document_number', 1080931780)->first();
        if ($person) {
            $existingUser = User::where('person_id', $person->id)->first();
            if ($existingUser) {
                $existingUser->update([
                    'nickname' => 'SofiaAscencio',
                    'email' => 'sofiaascencio49@gmail.com',
                    'password' => $existingUser->password ?? bcrypt('password')
                ]);
            } else {
                User::updateOrCreate(['nickname' => 'SofiaAscencio'], [
                    'person_id' => $person->id,
                    'email' => 'sofiaascencio49@gmail.com',
                    'password' => bcrypt('password')
                ]);
            }
        }
    }
}