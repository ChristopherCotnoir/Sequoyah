<?php

class SyllabaryController extends BaseController
{
	public function ShowGrid()
  {      
    $vowels = array('a', 'e', 'i', 'o', 'u');
    $consonants = array('b', 'd', 'f', 'g', 'h');
    return View::make('pages.syllabary', array(
      'vowels' => $vowels,
      'consonants' => $consonants,
      'starting_symbol' => 9985 // The starting wingdings symbol hex code in decimal.
    ));
  }
}
