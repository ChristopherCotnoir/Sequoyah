<?php

use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
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
    }

}

class SyllabaryColumnHeaderSeeder extends Seeder {
    public function run()
    {
        DB::table('syllabary_column_header')->truncate();

        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'a',
            'index' => 0
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'e',
            'index' => 1
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'i',
            'index' => 2
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'o',
            'index' => 3
        ));
        SyllabaryColumnHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'u',
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
            'index' => 0
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'd',
            'index' => 1
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'f',
            'index' => 2
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'g',
            'index' => 3
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'h',
            'index' => 4
        ));
    }
}
