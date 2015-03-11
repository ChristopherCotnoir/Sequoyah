<?php namespace Sequoyah\Http\Controllers;

class SyllabaryController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function ShowGrid()
  {
		$vowels = array('a', 'e', 'i', 'o', 'u');
		$consonants = array('b', 'd', 'f', 'g', 'h');
		// $ipa_symbols_dec = array(593,592,594,230,595,665,946,596,597,231,599,598,240,676,601,600,602,603,604,605,606,607,644,609,608,610,667,614,615,295,613,668,616,618,669,621,620,619,622,671,625,623,624,331,627,626,628,248,629,632,952,339,630,664,633,634,638,635,640,641,637,642,643,648,679,649,650,651,11377,652,611,612,653,967,654,655,657,656,658,660,673,661,674,448,449,450,451);
		// $ipa_symbols_hex=array('0251','0250','0252','00E6','0253','0299','03B2','0254','0255','00E7','0257','0256','00F0','02A4','0259','0258','025A','025B','025C','025D','025E','025F','0284','0261','0260','0262','029B','0266','0267','0127','0265','029C','0268','026A','029D','026D','026C','026B','026E','029F','0271','026F','0270','014B','0273','0272','0274','00F8','0275','0278','03B8','0153','0276','0298','0279','027A','027E','027B','0280','0281','027D','0282','0283','0288','02A7','0289','028A','028B','2C71','028C','0263','0264','028D','03C7','028E','028F','0291','0290','0292','0294','02A1','0295','02A2','01C0','01C1','01C2','01C3');
		return view('pages.syllabary', array(
			'vowels' => $vowels,
			'consonants' => $consonants,
			'starting_symbol' => 9985 // The starting wingdings symbol hex code in decimal.
		));
	}
}
