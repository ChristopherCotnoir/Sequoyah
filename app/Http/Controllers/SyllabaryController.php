<?php namespace Sequoyah\Http\Controllers;

// $ipa_symbols_dec = array(593,592,594,230,595,665,946,596,597,231,599,598,240,676,601,600,602,603,604,605,606,607,644,609,608,610,667,614,615,295,613,668,616,618,669,621,620,619,622,671,625,623,624,331,627,626,628,248,629,632,952,339,630,664,633,634,638,635,640,641,637,642,643,648,679,649,650,651,11377,652,611,612,653,967,654,655,657,656,658,660,673,661,674,448,449,450,451);
// $ipa_symbols_hex=array('0251','0250','0252','00E6','0253','0299','03B2','0254','0255','00E7','0257','0256','00F0','02A4','0259','0258','025A','025B','025C','025D','025E','025F','0284','0261','0260','0262','029B','0266','0267','0127','0265','029C','0268','026A','029D','026D','026C','026B','026E','029F','0271','026F','0270','014B','0273','0272','0274','00F8','0275','0278','03B8','0153','0276','0298','0279','027A','027E','027B','0280','0281','027D','0282','0283','0288','02A7','0289','028A','028B','2C71','028C','0263','0264','028D','03C7','028E','028F','0291','0290','0292','0294','02A1','0295','02A2','01C0','01C1','01C2','01C3');


use Sequoyah\Models\SyllabaryColumnHeader;
use Sequoyah\Models\SyllabaryRowHeader;
use Sequoyah\Models\SyllabaryCell;
use Sequoyah\Models\Symbol;
use Sequoyah\Models\UndoRecord;
use Sequoyah\Models\Syllabary;
use Sequoyah\Models\Project;
use Sequoyah\Models\ProjectMembers;
use Illuminate\Support\Facades\Input;
use Request;
use Auth;
use Illuminate\Html\HtmlServiceProvider;

class SyllabaryController extends Controller
{
    private function _getUserSyllabaryRole($user_id, $syllabary_id)
    {
      $project = Project::where('syllabary_id', '=', $syllabary_id)->first();
      if ($project == NULL)
        return -1;

      $membership = ProjectMembers::where('project_id', '=', $project->project_id)->
                                    where('user_id', '=', $user_id)->first();

      if ($membership == NULL)
        return -1;

      return $membership->access;
    }

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
    public function ShowGrid($SyllabaryId)
    {
        $user = Auth::user();

        if ($user == NULL)
          return redirect("/auth/login");

        $role = $this->_getUserSyllabaryRole($user->id, $SyllabaryId);

        if ($role == -1)
          return redirect("/settings");

        return view('pages.syllabary', array(
            'SyllabaryId' => $SyllabaryId, 'Role' => $role
        ));
    }

    public function GetGrid($SyllabaryId)
    {
        $vowels = array();
        $consonants = array();

        // TODO - Grab the current syllabary ID from the project data

        $firstDbColHeader = SyllabaryColumnHeader::where('syllabary_id', '=', $SyllabaryId)->
        where('prev_id', '=', -1)->first();
        $dbColHeaders = SyllabaryColumnHeader::where('syllabary_id', '=', $SyllabaryId)->get();

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


        $firstDbRowHeader = SyllabaryRowHeader::where('syllabary_id', '=', $SyllabaryId)->
        where('prev_id', '=', -1)->first();
        $dbRowHeaders = SyllabaryRowHeader::where('syllabary_id', '=', $SyllabaryId)->get();

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
        $dbCells = SyllabaryCell::where('syllabary_id', '=', $SyllabaryId)->get();

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

        $firstDbColHeader = SyllabaryColumnHeader::where('syllabary_id', '=', $SyllabaryId)->
        where('prev_id', '=', -1)->first();
        $dbColHeaders = SyllabaryColumnHeader::where('syllabary_id', '=', $SyllabaryId)->get();

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


        $firstDbRowHeader = SyllabaryRowHeader::where('syllabary_id', '=', $SyllabaryId)->
        where('prev_id', '=', -1)->first();
        $dbRowHeaders = SyllabaryRowHeader::where('syllabary_id', '=', $SyllabaryId)->get();

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
        $dbCells = SyllabaryCell::where('syllabary_id', '=', $SyllabaryId)->get();

        foreach($dbCells as $cell) {
            $cells[$cell->row_id][$cell->col_id] = $cell;
        }

        return response()->json([ 'test' => null, 'cells' => $cells, 'vowels' => $vowels, 'consonants' => $consonants ]);
    }


    public function AddColumn($syllabaryId, $relativeId = NULL, $suppressUndo = false)
    {
        $ipa = Input::get('ipa');

        $headers = SyllabaryColumnHeader::where('syllabary_id', '=', $SyllabaryId)->get();

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
        $lastHeader = SyllabaryColumnHeader::where('syllabary_id', '=', $SyllabaryId)->
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

        if (!$suppressUndo) {
            UndoRecord::create([
                'syllabary_id' => $syllabaryId,
                'json_data' => json_encode([
                    'action' => 'add_column',
                    'col_id' => $newHeader->id,
                ]),
            ]);
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

        $cells = SyllabaryCell::where('col_id', '=', $columnId)->get();
        foreach($cells as $cell)
        {
            $cell->deleted = false;
            $cell->save();
        }

        return response()->json(['success' => True]);
    }

    public function AddRow($syllabaryId, $relativeId, $suppressUndo = false)
    {
        $ipa = Input::get('ipa');

        $headers = SyllabaryRowHeader::where('syllabary_id', '=', $SyllabaryId)->get();

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
        $lastHeader = SyllabaryRowHeader::where('syllabary_id', '=', $SyllabaryId)->
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
        if (!$suppressUndo) {
            UndoRecord::create([
                'syllabary_id' => $syllabaryId,
                'json_data' => json_encode([
                    'action' => 'add_row',
                    'row_id' => $newHeader->id,
                ]),
            ]);
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
        
        $cells = SyllabaryCell::where('row_id', '=', $rowId)->get();
        foreach($cells as $cell)
        {
            $cell->deleted = false;
            $cell->save();
        }

        return response()->json(['success' => True]);

    }

    public function RestoreCell($syllabaryId, $rowId, $colId, $suppressUndo = false)
    {
        $cell = SyllabaryCell::where('row_id', '=', $rowId)->
        where('col_id', '=', $colId)->first();
        if ($cell != NULL) {
            if ($cell->deleted == false)
                $cell->symbol_id = NULL;
            else
                $cell->deleted = false;
            $cell->save();
        } 

        if (!$suppressUndo) {
            UndoRecord::create([
                'syllabary_id' => $syllabaryId,
                'json_data' => json_encode([
                    'action' => 'restore_cell',
                    'row_id' => $rowId,
                    'col_id' => $colId,
                ]),
            ]);
        }

        return response()->json(array('success' => true));
    }

    public function RemoveCell($syllabaryId, $rowId, $colId, $suppressUndo = false)
    {
        $cell = SyllabaryCell::where('row_id', '=', $rowId)->
        where('col_id', '=', $colId)->first();
        if ($cell != NULL) {
            $cell->deleted = true;
            $cell->save();
        } else {
            SyllabaryCell::create(array(
                'syllabary_id' => $SyllabaryId,
                'row_id' => $rowId,
                'col_id' => $colId,
                'deleted' => true,
                'symbol_id' => NULL,
                ));
        }

        if (!$suppressUndo) {
            UndoRecord::create([
                'syllabary_id' => $syllabaryId,
                'json_data' => json_encode([
                    'action' => 'remove_cell',
                    'row_id' => $rowId,
                    'col_id' => $colId,
                ]),
            ]);
        }

        return response()->json(array('success' => true));
    }

    public function GetCellCustomSymbolId($syllabaryId, $rowId, $colId)
    {
        $cell = SyllabaryCell::where('row_id', '=', $rowId)->
        where('col_id', '=', $colId)->first();
        if ($cell != NULL) {
            if ($cell->symbol_id != NULL) {
                $symbol_id = $cell->symbol_id;
            } else {
                $symbol = Symbol::create(['symbol_data' => '']);
                $cell->symbol_id = $symbol->id;
                $cell->save();

                $symbol_id = $symbol->id;
            }
        } else {
            $symbol = Symbol::create(['symbol_data' => '']);
            $symbol_id = $symbol->id;
            SyllabaryCell::create(array(
                'syllabary_id' => $SyllabaryId,
                'row_id' => $rowId,
                'col_id' => $colId,
                'deleted' => false,
                'symbol_id' => $symbol->id,
                ));
        }

        return response()->json(['success' => true, 'symbol_id' => $symbol_id]);
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
        $oldSymbolData = $symbol->symbol_data;
        $symbol->symbol_data = $svgData;
        $symbol->save();

        UndoRecord::create([
            'syllabary_id' => $SyllabaryId,
            'json_data' => json_encode([
                'action' => 'update_symbol',
                'symbol_id' => $symbolId,
                'old_symbol_data' => $oldSymbolData,
            ]),
        ]);

        return response()->json(array('success' => true));
    }

    public function TestSvg($symbolId)
    {
        $symbol = Symbol::find($symbolId);

        if ($symbol == false)
            return '<b>Symbol not found!</b>';

        return '<body>' . $symbol->symbol_data . '</body>';
    }
    
    public function EditVowel($syllabaryId, $columnId, $vowel)
    {
        $column = SyllabaryColumnHeader::where('syllabary_id', '=', $syllabaryId)->
                                         where('id', '=', $columnId)->first();
        if($column == NULL)
            return response()->json(['success' => false]);

        if($vowel == "-")
        {
            $vowel = "";
        }

        $column->ipa = $vowel;
        $column->save();

        return response()->json(['success' => true]);
    
    }
    
    public function EditConsonant($syllabaryId, $rowId, $consonant)    
    {
        $row = SyllabaryRowHeader::where('syllabary_id', '=', $syllabaryId)->
                                   where('id', '=', $rowId)->first();
        if($row == NULL)
            return response()->json(['success' => false]);

        if($consonant == "-")
        {
            $consonant = "";
        }

        $row->ipa = $consonant;
        $row->save();

        return response()->json(['success' => true]);    
    }

    public function UndoAction($syllabaryId)
    {
        $undo = UndoRecord::where('syllabary_id', '=', $syllabaryId)->
                            orderBy('created_at', 'desc')->first();

        if ($undo == NULL)
            return response()->json(['success' => false]);


        $undoData = json_decode($undo->json_data, true);

        if ($undoData['action'] == "add_row") {
            $rowId = $undoData['row_id'];
            $this->RemoveRow($syllabaryId, $rowId, true);
        } else if ($undoData['action'] == 'remove_row') {

        } else if ($undoData['action'] == 'add_column') {
            $colId = $undoData['col_id'];
            $this->RemoveColumn($syllabaryId, $colId, true);
        } else if ($undoData['action'] == 'remove_column') {

        } else if ($undoData['action'] == 'remove_cell') {
            $rowId = $undoData['row_id'];
            $colId = $undoData['col_id'];
            $this->RestoreCell($syllabaryId, $rowId, $colId, true);
        } else if ($undoData['action'] == 'restore_cell') {
            $rowId = $undoData['row_id'];
            $colId = $undoData['col_id'];
            $this->RemoveCell($syllabaryId, $rowId, $colId, true);
        } else if ($undoData['action'] == 'update_symbol') {
            $symbolId = $undoData['symbol_id'];
            $symbolData = $undoData['old_symbol_data'];
            $symbol = Symbol::find($symbolId);
            if ($symbol != NULL) {
                $symbol->symbol_data = $symbolData;
                $symbol->save();
            }
        }

        $undo->delete();

        return response()->json(['success' => true]);
    }
}

