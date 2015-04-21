<?php namespace Sequoyah\Http\Controllers;

// $ipa_symbols_dec = array(593,592,594,230,595,665,946,596,597,231,599,598,240,676,601,600,602,603,604,605,606,607,644,609,608,610,667,614,615,295,613,668,616,618,669,621,620,619,622,671,625,623,624,331,627,626,628,248,629,632,952,339,630,664,633,634,638,635,640,641,637,642,643,648,679,649,650,651,11377,652,611,612,653,967,654,655,657,656,658,660,673,661,674,448,449,450,451);
// $ipa_symbols_hex=array('0251','0250','0252','00E6','0253','0299','03B2','0254','0255','00E7','0257','0256','00F0','02A4','0259','0258','025A','025B','025C','025D','025E','025F','0284','0261','0260','0262','029B','0266','0267','0127','0265','029C','0268','026A','029D','026D','026C','026B','026E','029F','0271','026F','0270','014B','0273','0272','0274','00F8','0275','0278','03B8','0153','0276','0298','0279','027A','027E','027B','0280','0281','027D','0282','0283','0288','02A7','0289','028A','028B','2C71','028C','0263','0264','028D','03C7','028E','028F','0291','0290','0292','0294','02A1','0295','02A2','01C0','01C1','01C2','01C3');


use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
use Sequoyah\Models\SyllabaryCell;
use Sequoyah\Models\Symbol;
use Illuminate\Support\Facades\Input;
use Request;
use Illuminate\Html\HtmlServiceProvider;

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
        return view('pages.syllabary');
    }

    public function GetGrid($SyllabaryId)
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
            array_push($vowels, array('ipa' => $header->ipa, 'symbol_id' => $header->symbol_id, 'header_id' => $header->id, 'audio_sample' => $header->audio_sample));
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
            array_push($consonants, array('ipa' => $header->ipa, 'symbol_id' => $header->symbol_id, 'header_id' => $header->id, 'audio_sample' => $header->audio_sample));
            if ($header->next_id == -1)
                $header = NULL;
            else
                $header = $rowHeaderList[$header->next_id];
        }

        $cells = array(array());
        $dbCells = SyllabaryCell::where('syllabary_id', '=', 1)->get();

        foreach($dbCells as $cell) {
            $cells[$cell->row_id][$cell->col_id] = $cell;
        }

        return view('sections.syllabary-grid', array(
            'vowels' => $vowels,
            'consonants' => $consonants,
            'cells' => $cells,
            ));
    }
    public function GetGridJson($SyllabaryId)
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
            array_push($vowels, array('ipa' => $header->ipa, 'symbol' => $header->symbol, 'header_id' => $header->id, 'audio_sample' => $header->audio_sample));
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
            array_push($consonants, array('ipa' => $header->ipa, 'symbol' => $header->symbol, 'header_id' => $header->id, 'audio_sample' => $header->audio_sample));
            if ($header->next_id == -1)
                $header = NULL;
            else
                $header = $rowHeaderList[$header->next_id];
        }

        $cells = array(array());
        $dbCells = SyllabaryCell::where('syllabary_id', '=', 1)->get();

        foreach($dbCells as $cell) {
            $cells[$cell->row_id][$cell->col_id] = $cell;
        }

        return response()->json([ 'test' => null, 'cells' => $cells, 'vowels' => $vowels, 'consonants' => $consonants ]);
    }


    public function AddColumn($syllabaryId, $relativeId = NULL)
    {
        $ipa = Input::get('ipa');
        if ($ipa == False)
            return response()->json(['success' => False]);

        $headers = SyllabaryColumnHeader::where('syllabary_id', '=', 1)->get();

        $newSymbol = Symbol::create(array(
            'symbol_data' => '',
            ));

    // If we specify that we want to add to the right of a given header.
        if ($relativeId != NULL) {
    // If we pass a negative relative column ID, that means we want to add to
    // to the left of that column instead of the right.

            if ($relativeId < 0) {
                $leftHeader = $headers->find(($relativeId * -1));
                $rightHeader = $leftHeader;
                $leftHeader = $headers->find($leftHeader->prev_id);
            } else {
                $leftHeader = $headers->find($relativeId);
                $rightHeader = $headers->find($leftHeader->next_id);
            }

            $newHeader = SyllabaryColumnHeader::create(array(
                'syllabary_id' => $syllabaryId,
                'ipa' => $ipa,
                'symbol_id' => $newSymbol->id,
                'prev_id' => ($leftHeader != NULL) ? $leftHeader->id : -1,
                'next_id' => ($rightHeader != NULL) ? $rightHeader->id : -1,
                ));

            if ($leftHeader != NULL) {
                $leftHeader->next_id = $newHeader->id;
                $leftHeader->save();
            }

            if ($rightHeader != NULL) {
                $rightHeader->prev_id = $newHeader->id;
                $rightHeader->save();
            }
    } else { // If we want to just add to the end of the list.
        $lastHeader = SyllabaryColumnHeader::where('syllabary_id', '=', 1)->
        orderBy('next_id')->first();

        $newHeader = SyllabaryColumnHeader::create(array(
            'syllabary_id' => $syllabaryId,
            'ipa' => $ipa,
            'symbol_id' => $newSymbol->id,
            'prev_id' => ($lastHeader != NULL) ? $lastHeader->id : -1,
            'next_id' => -1,
            ));

        if ($lastHeader != NULL) {
            $lastHeader->next_id = $newHeader->id;
            $lastHeader->save();
        }
    }


    return response()->json(['success' => True]);
    }

    public function RemoveColumn($syllabaryId, $columnId)
    {
        $colHeaders = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->get();

        $selectedHeader = $colHeaders->find($columnId);

        if ($selectedHeader == NULL)
            return response()->json(['success' => False]);

        if ($selectedHeader->prev_id != -1) {
            $prevHeader = $colHeaders->find($selectedHeader->prev_id);
            $prevHeader->next_id = $selectedHeader->next_id;
            $prevHeader->save();
        }

        if ($selectedHeader->next_id != -1) {
            $nextHeader = $colHeaders->find($selectedHeader->next_id);
            $nextHeader->prev_id = $selectedHeader->prev_id;
            $nextHeader->save();
        }

        $selectedHeader->delete();

        return response()->json(['success' => True]);
    }

    public function AddRow($syllabaryId, $relativeId)
    {
        $ipa = Input::get('ipa');
        if ($ipa == False)
            return response()->json(['success' => False]);

        $headers = SyllabaryRowHeader::where('syllabary_id', '=', 1)->get();

        $newSymbol = Symbol::create(array(
            'symbol_data' => '',
            ));

    // If we specify that we want to add to the bottom of a given header.
        if ($relativeId != NULL) {
    // If we pass a negative relative row ID, that means we want to add to
    // to the top of that row instead of the right.

            if ($relativeId < 0) {
                $topHeader = $headers->find(($relativeId * -1));
                $bottomHeader = $topHeader;
                $topHeader = $headers->find($topHeader->prev_id);
            } else {
                $topHeader = $headers->find($relativeId);
                $bottomHeader = $headers->find($topHeader->next_id);
            }

            $newHeader = SyllabaryRowHeader::create(array(
                'syllabary_id' => $syllabaryId,
                'ipa' => $ipa,
                'symbol_id' => $newSymbol->id,
                'prev_id' => ($topHeader != NULL) ? $topHeader->id : -1,
                'next_id' => ($bottomHeader != NULL) ? $bottomHeader->id : -1,
                ));

            if ($topHeader != NULL) {
                $topHeader->next_id = $newHeader->id;
                $topHeader->save();
            }

            if ($bottomHeader != NULL) {
                $bottomHeader->prev_id = $newHeader->id;
                $bottomHeader->save();
            }
    } else { // If we want to just add to the end of the list.
        $lastHeader = SyllabaryRowHeader::where('syllabary_id', '=', 1)->
        orderBy('next_id')->first();

        $newHeader = SyllabaryRowHeader::create(array(
            'syllabary_id' => $syllabaryId,
            'ipa' => $ipa,
            'symbol_id' => $newSymbol->id,
            'prev_id' => ($lastHeader != NULL) ? $lastHeader->id : -1,
            'next_id' => -1,
            ));

        if ($lastHeader != NULL) {
            $lastHeader->next_id = $newHeader->id;
            $lastHeader->save();
        }
    }

    return response()->json(['success' => True]);
    }

    public function RemoveRow($syllabaryId, $rowId)
    {
        $rowHeaders = SyllabaryRowHeader::where('syllabary_id', '=', $syllabaryId)->get();

        $selectedHeader = $rowHeaders->find($rowId);

        if ($selectedHeader == NULL)
            return response()->json(['success' => False]);

        if ($selectedHeader->prev_id != -1) {
            $prevHeader = $rowHeaders->find($selectedHeader->prev_id);
            $prevHeader->next_id = $selectedHeader->next_id;
            $prevHeader->save();
        }

        if ($selectedHeader->next_id != -1) {
            $nextHeader = $rowHeaders->find($selectedHeader->next_id);
            $nextHeader->prev_id = $selectedHeader->prev_id;
            $nextHeader->save();
        }

        $selectedHeader->delete();

        return response()->json(['success' => True]);

    }

    public function RestoreCell($syllabaryId, $rowId, $colId)
    {
        $cell = SyllabaryCell::where('row_id', '=', $rowId)->
        where('col_id', '=', $colId)->first();
        if ($cell != NULL) {
            $cell->deleted = false;
            $cell->save();
        } else {
            $symbol = Symbol::create(['symbol_data' => '']);
            $cell = SyllabaryCell::create(array(
                'syllabary_id' => 1,
                'row_id' => $rowId,
                'col_id' => $colId,
                'deleted' => false,
                'symbol_id' => $symbol->id,
                ));
        }

        return response()->json(array('success' => true));
    }

    public function RemoveCell($syllabaryId, $rowId, $colId)
    {
        $cell = SyllabaryCell::where('row_id', '=', $rowId)->
        where('col_id', '=', $colId)->first();
        if ($cell != NULL) {
            $cell->deleted = true;
            $cell->save();
        } else {
            SyllabaryCell::create(array(
                'syllabary_id' => 1,
                'row_id' => $rowId,
                'col_id' => $colId,
                'deleted' => true,
                ));
        }
        return response()->json(array('success' => true));
    }

    public function GetSymbolData($symbolId)
    {
        $symbol = Symbol::find($symbolId);

        if ($symbol == false)
            return response()->json(array('success' => false));

    // If there is no data in the symbol, return a blank placeholder.
        if ($symbol->symbol_data == "") {
            $symbol->symbol_data = "<?xml version='1.0'?><svg width='512' height='512' xmlns='http://www.w3.org/2000/svg' xmlns:svg='http://www.w3.org/2000/svg'></svg>";
        }
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
}

