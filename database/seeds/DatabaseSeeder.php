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
      'name' => 'Tester',
      'username' => 'tester',
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
  }
}

class ProjectsSeeder extends Seeder {
  public function run()
  {
    DB::table('projects')->truncate();
    Project::create([
      'name' => 'Demo Project',
      'syllabary_id' => 1,
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
            'symbol_id' => 1,
            'next_id' => 2,
            'prev_id' => -1,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'd',
            'symbol_id' => 2,
            'next_id' => 3,
            'prev_id' => 1,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'f',
            'symbol_id' => 3,
            'next_id' => 4,
            'prev_id' => 2
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'g',
            'symbol_id' => 4,
            'next_id' => 5,
            'prev_id' => 3,
        ));
        SyllabaryRowHeader::create(array(
            'syllabary_id' => 1,
            'ipa' => 'h',
            'symbol_id' => 5,
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
        'symbol_data' => '<?xml version="1.0" encoding="iso-8859-1"?><!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="512px" height="512px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"><g><path d="M352,448h128l32-64v128H320V404.893C385.557,376.65,432,306.312,432,224c0-107.216-78.799-191.133-176-191.133c-97.203,0-176,83.916-176,191.133c0,82.312,46.443,152.65,112,180.893V512H0V384l32,64h128v-16.295C66.185,398.475,0,318.004,0,224C0,100.288,114.615,0,256,0s256,100.288,256,224c0,94.004-66.186,174.475-160,207.705V448z"/></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>'
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
        'symbol_data' => '<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg"> <g> <title>Layer 1</title> <path fill="black" id="svg_1" d="m42.021439,273.201385c-1.093723,1.218231 -2.460876,1.598724 -4.115135,1.218231c-1.6269,-0.411194 -3.185459,-1.218231 -4.648315,-2.436005s-2.460876,-2.6492 -3.007725,-4.247925c-0.546873,-1.628906 -0.2871,-3.273163 0.820284,-4.871429c14.956636,-20.720703 31.717909,-35.472992 50.311174,-44.242081c18.56591,-8.738892 37.145515,-13.138733 55.711433,-13.138733c10.554398,0 22.011108,1.628967 34.411194,4.871902c9.091537,-5.297928 18.101074,-9.834869 27.028534,-13.701797s17.198807,-7.612183 24.854843,-11.266357c5.085815,-2.024796 8.44899,-6.302917 10.089615,-12.818619c1.626892,-6.485504 2.460815,-14.219849 2.460815,-23.156158c0,-17.066589 -0.73822,-31.286446 -2.187454,-42.64386c-1.449158,-11.387611 -4.101425,-20.522331 -7.929443,-27.418976c-3.828003,-6.926895 -9.2146,-12.012077 -16.132385,-15.254593c-6.945129,-3.242943 -16.050339,-5.267735 -27.343033,-6.090111c-2.187439,0 -3.828033,-1.095989 -4.921738,-3.334057c-1.093719,-2.20734 -1.640579,-4.551781 -1.640579,-6.957516c0,-2.435978 0.54686,-4.643318 1.640579,-6.66811s2.720642,-3.045033 4.908096,-3.045033c11.675461,0 24.964172,0.654606 39.920776,1.903057c14.956665,1.279072 29.024643,1.903004 42.176682,1.903004c7.683319,0 14.888214,-0.213223 21.641998,-0.623932c6.753693,-0.441864 13.329681,-0.867935 19.700623,-1.279072s12.851196,-0.837261 19.413513,-1.248451c6.562378,-0.44138 13.671509,-0.654606 21.341248,-0.654606c2.187439,0 3.732361,1.004929 4.648315,3.02972s1.285126,4.217251 1.09375,6.668114s-0.820313,4.750172 -1.914032,6.957512c-1.093719,2.222706 -2.556549,3.334057 -4.361206,3.334057c-11.320038,0.837688 -20.425232,2.557663 -27.356659,5.176674s-12.222382,6.607246 -15.845306,11.859673c-3.664001,5.267731 -6.015503,12.163948 -7.122864,20.65937c-1.09375,8.540924 -1.640594,19.273926 -1.640594,32.230011c0,12.575203 1.626892,24.024101 4.908051,34.376549s7.587708,19.273926 12.86496,26.764359s11.374634,13.382217 18.319763,17.629654c6.917786,4.247925 14.026978,6.394455 21.327576,6.394455c5.837769,0 11.388367,-2.116287 16.67926,-6.363785c5.290894,-4.217239 10.39032,-8.769073 15.312103,-13.625626s9.939209,-9.393494 15.052368,-13.626099c5.099426,-4.216827 10.198883,-6.363785 15.29837,-6.363785c6.562317,0 13.028961,2.146957 19.413513,6.363785c6.384613,4.247925 12.400116,9.393494 18.046417,15.468292s10.937256,12.636002 15.858948,19.715256c4.908081,7.0793 9.2146,13.260483 12.837616,18.528214c1.093658,1.628967 1.285095,3.364243 0.560455,5.206436c-0.751862,1.811996 -1.927673,3.456223 -3.568207,4.841721c-1.640594,1.431 -3.376892,2.344437 -5.19519,2.770447c-1.818298,0.380997 -3.281128,0 -4.374908,-1.217712c-6.193176,-9.332626 -13.0289,-16.22934 -20.507263,-20.690048c-7.478333,-4.490921 -14.314056,-6.713623 -20.507263,-6.713623c-4.730347,0 -10.007538,2.862 -15.858978,8.540451c-5.824005,5.67897 -12.126617,11.860138 -18.853027,18.589066c-6.753693,6.714096 -13.958588,12.910156 -21.600952,18.589081c-7.669708,5.678497 -15.503479,8.540924 -23.528687,8.540924c-8.380615,0 -15.58551,-3.745178 -21.600952,-11.266296c-6.001862,-7.520691 -12.030945,-15.756851 -18.046387,-24.708969c-6.001831,-8.921432 -12.468475,-17.158066 -19.413574,-24.648026c-6.917816,-7.521118 -15.489838,-11.266357 -25.688812,-11.266357c-8.380615,0 -17.868652,1.720444 -28.423065,5.176239s-21.136185,8.617111 -31.704239,15.529114c11.320007,5.678497 21.792435,12.483658 31.458191,20.400589c9.665726,7.931885 18.155777,17.157639 25.442642,27.708481s13.028992,22.120575 17.226135,34.726379s6.302551,26.201263 6.302551,40.801666c0,19.501984 -3.103424,36.248871 -9.296631,50.255493c-6.193207,14.036804 -14.314056,25.394226 -24.335297,34.133118c-10.021179,8.70816 -21.245544,15.224365 -33.631897,19.471802s-24.595047,6.393951 -36.639679,6.393951c-10.568069,0 -21.600983,-1.598236 -33.085052,-4.871399c-11.48407,-3.212341 -21.942772,-8.677979 -31.430801,-16.411896c-9.474365,-7.673035 -17.335472,-17.903778 -23.528694,-30.6922c-6.193176,-12.758179 -9.296616,-28.667877 -9.296616,-47.728516c0,-28.758911 5.09948,-52.569733 15.284744,-71.417603s22.763084,-34.559128 37.69236,-47.134766c-1.093719,0 -2.187439,-0.091049 -3.281158,-0.304337c-1.093719,-0.182602 -2.187439,-0.304337 -3.281166,-0.304337c-16.364799,0 -32.046021,3.455795 -46.975327,10.352493c-14.929276,6.866028 -27.671116,16.016068 -38.239204,27.373459zm185.358353,76.456818c0,-29.611542 -5.099426,-52.783081 -15.271088,-69.438416c-10.198929,-16.624664 -23.104828,-28.39328 -38.758728,-35.289993c-11.648117,12.575211 -21.300201,27.677811 -28.928909,45.353439s-11.456711,38.2742 -11.456711,61.826202c0,26.794556 4.730316,47.195618 14.177338,61.217133c9.460709,13.975952 20.561981,20.994324 33.303818,20.994324c13.835571,0 25.114532,-7.200989 33.850693,-21.618774s13.083588,-35.427032 13.083588,-63.043915z"/> </g></svg>'
      ));	
    }
}
