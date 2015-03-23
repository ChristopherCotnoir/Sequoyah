<?php

use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
use Sequoyah\Models\Symbol;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('SyllabaryColumnHeaderSeeder');
        $this->call('SyllabaryRowHeaderSeeder');
        $this->call('SymbolsSeeder');
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
            'index' => 0
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'e',
            'symbol_id' => 3,
            'index' => 1
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'i',
            'symbol_id' => 2,
            'index' => 2
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'o',
            'symbol_id' => 1,
            'index' => 3
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'u',
            'symbol_id' => 4,
            'index' => 4
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
            'symbol_id' => 1,
            'index' => 0
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'd',
            'symbol_id' => 2,
            'index' => 1
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'f',
            'symbol_id' => 3,
            'index' => 2
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'g',
            'symbol_id' => 4,
            'index' => 3
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'h',
            'symbol_id' => 1,
            'index' => 4
        ));
    }
}

class SymbolsSeeder extends Seeder {
    public function run()
    {
      DB::table('symbols')->truncate();

      // A test symbol of Pi found at http://www.flaticon.com/free-icon/pi-mathematical-constant-symbol_43102
      // by Freepik.
      Symbol::create(array(
        'symbol_data' => '<svg><line x1="50%" y1="0" x2="50%" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<svg><line x1="0" y1="50%" x2="100%" y2="50%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<svg><line x1="0" y1="0" x2="100%" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));

      Symbol::create(array(
        'symbol_data' => '<svg><line x1="100%" y1="0" x2="0" y2="100%" style="stroke:rgb(0,0,0);stroke-width:5"/></svg>'
      ));
    }
}
