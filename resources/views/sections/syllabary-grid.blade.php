<!--===========================================================================================================
                                            Column Control Panel 
============================================================================================================-->

@foreach($vowels as $colIndex => $vowel)
<div id="edit-column-modal-{{{ $colIndex }}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Syllabary</h4>
            </div>
            <div class="modal-body">
                
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addColumnLeft('-')">Add Column Left</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="removeSelectedColumn()">Remove Column</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addColumnRight('-')">Add Column Right</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Edit Vowel</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="editSymbol('{{{ $vowel['symbol_id'] 				}}}')">Edit Symbol</button>
            </div>
            <div class="modal-footer">
                <button type="button" class="flat-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endforeach

<!--===========================================================================================================
                                             Row Control Panel 
============================================================================================================-->
@foreach($consonants as $rowIndex => $consonant)
<div id="edit-row-modal-{{{ $rowIndex }}}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Syllabary</h4>
            </div>
            <div class="modal-body">
                
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addRowTop('-')">Add Row Top</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="removeSelectedRow()">Remove Row</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addRowBottom('-')">Add Row 				Bottom</button>
				<button type="button" class="btn btn-default" data-dismiss="modal">Edit Consonant</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="editSymbol('{{{ $consonant['symbol_id'] 				}}}')">Edit Symbol</button>
				
            </div>
            <div class="modal-footer">
                <button type="button" class="flat-button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endforeach

<!--===========================================================================================================
                                             Cell Control Panel 
============================================================================================================-->
@foreach($vowels as $colIndex => $vowel)
    @foreach($consonants as $rowIndex => $consonant)
	<div id="edit-symbol-modal-{{{ $colIndex }}}-{{{ $rowIndex }}}" class="modal fade">
    	<div class="modal-dialog">
        	<div class="modal-content">
            	<div class="modal-header">
                	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Edit Syllabary</h4>
				</div>
				<div class="modal-body">
                
					<button type="button" class="btn btn-default" data-dismiss="modal">Remove Cell</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Restore Cell</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Edit Symbol</button>
				
				</div>
				<div class="modal-footer">
					<button type="button" class="flat-button" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
    @endforeach
@endforeach

</div>

<!--==========================================================================================================
                                               Syllabary Grid
===========================================================================================================-->
<table class='syllabaryGrid' border='1'>
    <tr>
        <th class='headerCell' onclick='unselectAll()'></th>
        @foreach($vowels as $colIndex => $vowel)
        <th class='headerCell' id='col-{{{ $colIndex }}}' colId="{{{$vowel['header_id']}}}" onclick='selectColumn("{{{ $colIndex }}}")'>
            @if ($vowel['audio_sample'] != NULL)
            <img class="sampleBtn" src="/images/speaker.png" onclick="pronounceVowel('{{{ $vowel['header_id'] }}}')"></img>
            @endif
            <b>{{{ $vowel['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
        </th>
        @endforeach
    </tr>

    @foreach($consonants as $rowIndex => $consonant)
    <tr>
        <th class='headerCell' id='row-{{{ $rowIndex }}}' rowId="{{{$consonant['header_id']}}}" onclick='selectRow("{{{ $rowIndex }}}")'>
            @if ($consonant['audio_sample'] != NULL)
            <img class="sampleBtn" src="/images/speaker.png" onclick="pronounceConsonant('{{{ $consonant['header_id'] }}}')"></img>
            @endif
            <b>{{{ $consonant['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
        </th>
        @foreach($vowels as $colIndex => $vowel)
        <?php
          if (isset($cells[$consonant['header_id']][$vowel['header_id']])) {
            $cell = $cells[$consonant['header_id']][$vowel['header_id']];
            $cellDeleted = $cell->deleted;
          } else {
            $cellDeleted = false;
          }
        ?>

        <?php if (!$cellDeleted) { ?>
        <td class="syllableCell" id='cell-{{{ $colIndex }}}-{{{ $rowIndex }}}' colId="{{{$vowel['header_id']}}}" rowId="{{{$consonant['header_id']}}}" onclick='selectCell("{{{ $colIndex }}}", "{{{ $rowIndex }}}")'>
          <b>{{{ $consonant['ipa'] . $vowel['ipa'] }}}</b>
          <br>
          <div>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
          </div>
        </td>
        <?php } else { ?>
        <td class="syllableCell" id='cell-{{{ $colIndex }}}-{{{ $rowIndex }}}' colId="{{{$vowel['header_id']}}}" rowId="{{{$consonant['header_id']}}}" onclick='selectCell("{{{ $colIndex }}}", "{{{ $rowIndex }}}")'>
          <br>
          <div>
            <img src='data:image/svg+xml;utf8,<?xml version="1.0"?><svg width="512" height="512" xmlns="http://www.w3.org/2000/svg" xmlns:svg="http://www.w3.org/2000/svg"></svg>'></img>
          </div>
        </td>
        <?php } ?>
        @endforeach
    </tr>
    @endforeach
</table>
