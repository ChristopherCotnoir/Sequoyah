@extends('layouts.plain')
@section('head-custom')
<style>
  .centered {
    text-align: center;
  }
</style>
@stop
@section('content')
<main>
<h2 class='centered'>About Sequoyah</h2>
  <div class='paragraph space-bottom'>
  Sequoyah is a syllabary creation tool focused on providing endangered language groups the ability to
  generate a written alphabet for their spoken language.
  </div>

  <h2 class='centered'>Feasibility</h2>
  <div class='paragraph space-bottom'>
  Based on the requirements of this project, it is certainly feasible. First, the requirements are the following:

  <ul>
  <li>Allow the creation of a <a class='link' href='http://en.wikipedia.org/wiki/Syllabary'>syllabary</a> for the language</li>
  <li>Allow assigning custom characters to syllables of the language</li>
  <li>Provide the ability to download a <a class='link' href='http://en.wikipedia.org/wiki/TrueType'>TrueType font</a> of the generated written language to allow typing in the language</li>
  </ul>

  All of these requirements can be fulfilled by creating a web application using PHP and JavaScript.
  Creating a web application will allow for increased availability of the application and ease of use.
  </div>

  <h2 class='centered'>Competition</h2>
  <div class='paragraph'>
  Based on our current research, we have found that this project is very unique. We have yet to find any projects that
  are designed to generate written languages based on customized syllabaries.
  </div>
</main>
@stop
