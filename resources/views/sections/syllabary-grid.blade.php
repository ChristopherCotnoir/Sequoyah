<div style="height:300px">
<!--===========================================================================================================
                                            Column Control Panel 
============================================================================================================-->
@foreach($vowels as $colIndex => $vowel)
<div class="col-controls" id="col-control-{{{ $colIndex }}}">
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addColumnLeft('-')">Add Column Left</button>
    </form>
<!-- <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') }}}/remove'> -->
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="removeSelectedColumn()">Remove Column</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') + 1 }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addColumnRight('-')">Add Column Right</button>
    </form>
</div>
@endforeach

<!--===========================================================================================================
                                             Row Control Panel 
============================================================================================================-->
@foreach($consonants as $rowIndex => $consonant)
<div class="row-controls" id="row-control-{{{ $rowIndex }}}">
<!-- <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addRowTop('-')">Add Row Top</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') }}}/remove'> -->
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="removeSelectedRow()">Remove Row</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') + 1 }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addRowBottom('-')">Add Row Bottom</button>
    </form>
</div>
@endforeach

<!--===========================================================================================================
                                             Cell Control Panel 
============================================================================================================-->
@foreach($vowels as $colIndex => $vowel)
    @foreach($consonants as $rowIndex => $consonant)
    <div class="cell-controls" id="cell-control-{{{ $colIndex }}}-{{{ $rowIndex }}}">
        <form method='post'>
        <!-- Currently no buttons in this panel -->
        </form>
    </div>
    @endforeach
@endforeach

<!--===========================================================================================================
                                            General Control Panel
============================================================================================================-->
@foreach($vowels as $colIndex => $vowel)
<div class="gen-controls" id="gen-control-col-{{{ $colIndex }}}">
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="editSymbol('{{{ $vowel['symbol_id'] }}}')">Edit Symbol</button>
    </form>
</div>
@endforeach

@foreach($consonants as $rowIndex => $consonant)
<div class="gen-controls" id="gen-control-row-{{{ $rowIndex }}}">
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="editSymbol('{{{ $consonant['symbol_id'] }}}')">Edit Symbol</button>
    </form>
</div>
@endforeach

@foreach($vowels as $colIndex => $vowel)
    @foreach($consonants as $rowIndex => $consonant)
    <div class="gen-controls" id="gen-control-cell-{{{ $colIndex }}}-{{{ $rowIndex }}}">
        <form method='post'>
        <button type="button" class="btn btn-default">Edit Symbol</button>
        </form>
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
