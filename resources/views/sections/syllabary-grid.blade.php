

<!--==========================================================================================================
                                               Syllabary Grid
===========================================================================================================-->
<table class='syllabaryGrid' border='1'>
    <tr>
        <th class='headerCell' onclick='unselectAll()'></th>
        @foreach($vowels as $colIndex => $vowel)
        <th class='headerCell' id='col-{{{ $colIndex }}}' colId="{{{$vowel['header_id']}}}" onclick='selectColumn("{{{ $colIndex }}}")'>
            <b>{{{ $vowel['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
        </th>
        @endforeach
    </tr>

    @foreach($consonants as $rowIndex => $consonant)
    <tr>
        <th class='headerCell' id='row-{{{ $rowIndex }}}' rowId="{{{$consonant['header_id']}}}" onclick='selectRow("{{{ $rowIndex }}}")'>
            <b>{{{ $consonant['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
        </th>
        @foreach($vowels as $colIndex => $vowel)
        <td class="syllableCell" id='cell-{{{ $colIndex }}}-{{{ $rowIndex }}}' onclick='selectCell("{{{ $colIndex }}}", "{{{ $rowIndex }}}")'>
          <b>{{{ $consonant['ipa'] . $vowel['ipa'] }}}</b>
          <br>
          <div>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
          </div>
        </td>
        @endforeach
    </tr>
    @endforeach
</table>

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
                
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addColumnLeft('-')">Add Column 				Left</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="removeSelectedColumn()">Remove 				Column</button>
				<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addColumnRight('-')">Add Column 				Right</button>
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
