<?php namespace Sequoyah\Http\Controllers;

// $ipa_symbols_dec = array(593,592,594,230,595,665,946,596,597,231,599,598,240,676,601,600,602,603,604,605,606,607,644,609,608,610,667,614,615,295,613,668,616,618,669,621,620,619,622,671,625,623,624,331,627,626,628,248,629,632,952,339,630,664,633,634,638,635,640,641,637,642,643,648,679,649,650,651,11377,652,611,612,653,967,654,655,657,656,658,660,673,661,674,448,449,450,451);
        // $ipa_symbols_hex=array('0251','0250','0252','00E6','0253','0299','03B2','0254','0255','00E7','0257','0256','00F0','02A4','0259','0258','025A','025B','025C','025D','025E','025F','0284','0261','0260','0262','029B','0266','0267','0127','0265','029C','0268','026A','029D','026D','026C','026B','026E','029F','0271','026F','0270','014B','0273','0272','0274','00F8','0275','0278','03B8','0153','0276','0298','0279','027A','027E','027B','0280','0281','027D','0282','0283','0288','02A7','0289','028A','028B','2C71','028C','0263','0264','028D','03C7','028E','028F','0291','0290','0292','0294','02A1','0295','02A2','01C0','01C1','01C2','01C3');


use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
use Sequoyah\Models\Symbol;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

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
        $vowels = array();
        $consonants = array();

        // TODO - Grab the current syllabary ID from the project data
        
        $firstDbColHeader = SyllabaryColumnHeader::where('syllabary_id', '=', 1)->
                                                   where('prev_id', '=', -1)->first();
        $dbColHeaders = SyllabaryColumnHeader::where('syllabary_id', '=', 1)->get();

        $colHeaderList = array();
        foreach($dbColHeaders as $header) {
            $colHeaderList[$header->id] = $header;
        }

        $header = $firstDbColHeader;
        while($header != NULL) {
          array_push($vowels, array('ipa' => $header->ipa, 'symbol_id' => $header->symbol_id));
          if ($header->next_id == -1)
            $header = NULL;
          else
            $header = $colHeaderList[$header->next_id];
        }


        $firstDbRowHeader = SyllabaryRowHeader::where('syllabary_id', '=', 1)->
                                                   where('prev_id', '=', -1)->first();
        $dbRowHeaders = SyllabaryRowHeader::where('syllabary_id', '=', 1)->get();

        $rowHeaderList = array();
        foreach($dbRowHeaders as $header) {
            $rowHeaderList[$header->id] = $header;
        }

        $header = $firstDbRowHeader;
        while($header != NULL) {
          array_push($consonants, array('ipa' => $header->ipa, 'symbol_id' => $header->symbol_id));
          if ($header->next_id == -1)
            $header = NULL;
          else
            $header = $rowHeaderList[$header->next_id];
        }

        return view('pages.syllabary', array(
            'vowels' => $vowels,
            'consonants' => $consonants,
            'starting_symbol' => 9985 // The starting wingdings symbol hex code in decimal.
        ));
    }

    public function AddColumn($syllabaryId)
    {
        $ipa = Input::get('ipa');
        if ($ipa == False)
            return response()->json(['success' => False]);

        $headerCount = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->count();

        SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabaryId,
            'ipa' => $ipa,
            'index' => $headerCount - 1
        ));

        return response()->json(['success' => True]);
    }

    public function RemoveColumn($syllabaryId, $columnIndex)
    {
        $colHeader = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->
                                            where('index', '=', $columnIndex)->first();
        if ($colHeader == NULL)
            return response()->json(['success' => False]);

        $colHeader->delete();
        return response()->json(['success' => True]);
    }

    public function AddRow($syllabaryId)
    {
        $ipa = Input::get('ipa');
        if ($ipa == False)
            return response()->json(['success' => False]);

        $headerCount = SyllabaryRowHeader::where('syllabary_id', '=', $syllabaryId)->count();

        SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabaryId,
            'ipa' => $ipa,
            'index' => $headerCount - 1
        ));

        return response()->json(['success' => True]);

    }

    public function RemoveRow($syllabaryId, $rowIndex)
    {
        $rowHeader = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->
                                            where('index', '=', $columnIndex)->first();
        if ($rowHeader == NULL)
            return response()->json(['success' => False]);

        $rowHeader->delete();
        return response()->json(['success' => True]);

    }
    public function GetSymbolData($symbolId)
    {
      $symbol = Symbol::find($symbolId);

      if ($symbol == false)
        return response()->json(array('success' => false));

      return response($symbol->symbol_data, 200)->header('Content-Type', 'image/svg+xml');
/*
      return response()->json(array(
        'success' => true,
        'data' => $symbol->symbol_data
      ))
*/
    }

    public function UpdateSymbol($symbolId)
    {
        $symbol = Symbol::find($symbolId);

        if($symbol == false || !Input::has('svg'))
          return response()->json(array('success' => false));
        
        $svgData = base64_decode(Input::get('svg'));
        $symbol->symbol_data = $svgData;
        $symbol->save();
        return response()->json(array('success' => true));
    }

    public function TestSvg($symbolId)
    {
      $symbol = Symbol::find($symbolId);

      if ($symbol == false)
        return '<b>Symbol not found!</b>';

      return '<body>' . $symbol->symbol_data . '</body>';
    }

    public function UploadAudioSample($syllabaryId)
    {
        $targetDir = "/tmp/sequoyah/audioSample/";
        $targetFile = $targetDir . basename($_FILES['audioSample']['name']);
        $uploadOk = true;
        $audioFileType = pathinfo($targetFile, PATHINFO_EXTENSION);

        // Check if file name is already in use.

        if (file_exists($targetFile))
        {
             echo "File already exists.";
             $uploadOK = false;
        }

        // Audio format check.

        if (($audioFileType != "audio/wav") || ($audioFileType != "audio/mpeg") || 
              ($audioFileType != "audio/ogg"))
        {
             echo "Unsupported audio format. Use wav, mpeg, or ogg.";
             $uploadOk = false;
        }

        // Audio file size check.

        if($_Files['audioSample']['size'] > 5242880) // Max size is 5MB.
        {
             echo "File size too large.";
             $uploadOK = false;
        }
        elseif($_Files['audioSample']['size'] == 0)
        {
             echo "File size too small.";
             $uploadOK = false;
        }

        if ($uploadOK == false)
        {
             echo "File was not uploaded.";
        }
        elseif(move_uploaded_file($_FILE['audioSample']['tmpName'], $targetFile))
        {
             echo "The file" . basename($_FILE['audioSample']['name']) . " has been uploaded.";
        }
        else
        {
             echo "An unexpected error has occured while uploading file.";
        }
    }
}

