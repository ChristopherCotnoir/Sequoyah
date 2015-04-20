<?php

use Illuminate\Database\Seeder;

class ProjectRolesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('project_roles')->truncate();
		
		//name maxlen = 32
		DB::table('project_roles')->insert
		(
			[
				['name' => 'Guest'],
				['name' => 'Read'],
				['name' => 'ReadWrite'],
				['name' => 'Administrate']
			]
		);
    }

}
