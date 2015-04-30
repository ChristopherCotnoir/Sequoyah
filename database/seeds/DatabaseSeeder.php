<?php

use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
use Sequoyah\Models\Symbol;
use Sequoyah\Models\User;
use Sequoyah\Models\Syllabary;
use Sequoyah\Models\Project;
use Sequoyah\Models\ProjectMembers;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('UsersSeeder');
        $this->call('SyllabarySeeder');
        $this->call('ProjectsSeeder');
        $this->call('ProjectRolesTableSeeder');
        $this->call('ProjectMembersSeeder');
        $this->call('SyllabaryColumnHeaderSeeder');
        $this->call('SyllabaryRowHeaderSeeder');
        $this->call('SymbolsSeeder');
    }

}

class UsersSeeder extends Seeder {

  public function run()
  {
    DB::table('users')->truncate();

    User::create([
      'name' => 'Chris',
      'username' => 'ccotnoir',
      'password' => '$2y$10$aAe3xBMIG6dBiAa8kbXyc.rbQLWwv0wzaQaUiOSH8MJOyzUBF2u1a'
    ]);
    User::create([
      'name' => 'Nicholai',
      'username' => 'ngoodall',
      'password' => '$2y$10$aAe3xBMIG6dBiAa8kbXyc.rbQLWwv0wzaQaUiOSH8MJOyzUBF2u1a'
    ]);
    User::create([
      'name' => 'Preston',
      'username' => 'pbrown',
      'password' => '$2y$10$aAe3xBMIG6dBiAa8kbXyc.rbQLWwv0wzaQaUiOSH8MJOyzUBF2u1a'
    ]);
  }
}

class SyllabarySeeder extends Seeder {
  public function run()
  {
    DB::table('syllabaries')->truncate();
    Syllabary::create([
      'name' => 'Sequoyah Test',
    ]);
    Syllabary::create([
      'name' => 'Sequoyah Extra',
    ]);
    Syllabary::create([
      'name' => 'Sequoyah Extra 2',
    ]);
  }
}

class ProjectsSeeder extends Seeder {
  public function run()
  {
    DB::table('projects')->truncate();
    Project::create([
      'project_id' => 1,
      'name' => 'Demo Project 1',
      'syllabary_id' => 1,
    ]);
    Project::create([
      'project_id' => 2,
      'name' => 'Demo Project 2',
      'syllabary_id' => 2,
    ]);
    Project::create([
      'project_id' => 2,
      'name' => 'Demo Project 2',
      'syllabary_id' => 3,
    ]);
  }
}

class ProjectMembersSeeder extends Seeder {
  public function run()
  {
    DB::table('project_members')->truncate();
    ProjectMembers::create([
      'user_id' => 1,
      'project_id' => 1,
      'access' => 3, // Read/Write access
    ]);
    ProjectMembers::create([
      'user_id' => 2,
      'project_id' => 1,
      'access' => 2
    ]);
    ProjectMembers::create([
      'user_id' => 1,
      'project_id' => 2,
      'access' => 3
    ]);
    ProjectMembers::create([
      'user_id' => 3,
      'project_id' => 2,
      'access' => 1
    ]);
  }
}

class SyllabaryColumnHeaderSeeder extends Seeder {
    public function run()
    {
        DB::table('syllabary_column_header')->truncate();

        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'a',
            'symbol_id' => 4,
            'next_id' => 2,
            'prev_id' => -1,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'e',
            'symbol_id' => 3,
            'next_id' => 3,
            'prev_id' => 1,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'i',
            'symbol_id' => 2,
            'next_id' => 4,
            'prev_id' => 2,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'o',
            'symbol_id' => 1,
            'next_id' => 5,
            'prev_id' => 3,
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'u',
            'symbol_id' => 5,
            'next_id' => -1,
            'prev_id' => 4,
        ));
    }
}

class SyllabaryRowHeaderSeeder extends Seeder {
    public function run()
    {
        DB::table('syllabary_row_header')->truncate();

        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'b',
            'symbol_id' => 6,
            'next_id' => 2,
            'prev_id' => -1,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'd',
            'symbol_id' => 7,
            'next_id' => 3,
            'prev_id' => 1,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'f',
            'symbol_id' => 8,
            'next_id' => 4,
            'prev_id' => 2
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'g',
            'symbol_id' => 9,
            'next_id' => 5,
            'prev_id' => 3,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'h',
            'symbol_id' => 10,
            'next_id' => -1,
            'prev_id' => 4,
        ));
    }
}

class SymbolsSeeder extends Seeder {
    public function run()
    {
      DB::table('symbols')->truncate();

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><circle id="svg_18" r="105.621967" cy="256" cx="256" stroke-width="5" stroke="#000000" fill="#000000"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="0" x2="100%" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="100%" y1="0" x2="0" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg"><rect xmlns="http://www.w3.org/2000/svg" id="svg_1" height="168" width="392" y="156" x="54" stroke-linecap="null" stroke-linejoin="null" stroke-dasharray="null" stroke-width="null" fill="black"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><circle id="svg_18" r="105.621967" cy="256" cx="256" stroke-width="5" stroke="#000000" fill="#000000"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="0" y1="0" x2="100%" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"><line x1="100%" y1="0" x2="0" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg"><rect xmlns="http://www.w3.org/2000/svg" id="svg_1" height="168" width="392" y="156" x="54" stroke-linecap="null" stroke-linejoin="null" stroke-dasharray="null" stroke-width="null" fill="black"/></svg>'
      ));
    }
}
