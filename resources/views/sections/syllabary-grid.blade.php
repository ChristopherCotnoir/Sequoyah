<div style="height:500px">
<!--===========================================================================================================
                                            Column Control Panel 
============================================================================================================-->
@foreach($vowels as $colIndex => $vowel)
<div class="col-controls" id="col-control-{{{ $colIndex }}}">
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addColumnLeft('-')">Add Column Left</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="removeSelectedColumn()">Remove Column</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addColumnRight('-')">Add Column Right</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Edit Vowel</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="editSymbol('{{{ $vowel['symbol_id'] }}}')">Edit Symbol</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" id="vowel-audio">Pronounce Vowel</button>
    </form>
</div>
@endforeach

<!--===========================================================================================================
                                             Row Control Panel 
============================================================================================================-->
@foreach($consonants as $rowIndex => $consonant)
<div class="row-controls" id="row-control-{{{ $rowIndex }}}">
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addRowTop('-')">Add Row Top</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="removeSelectedRow()">Remove Row</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="addRowBottom('-')">Add Row Bottom</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Edit Consonant</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" onclick="editSymbol('{{{ $consonant['symbol_id'] }}}')">Edit Symbol</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default" id="vowel-audio">Pronounce Consonant</button>
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
        <button type="button" class="btn btn-default" onclick="removeCell({{{ $rowIndex + 1 }}}, {{{ $colIndex + 1 }}})">Remove Cell</button>
        </form>
        <form method='post'>
        <button type="button" class="btn btn-default">Restore Cell</button>
        </form>
        <form method='post'>
        <button type="button" class="btn btn-default">Edit Symbol</button>
        </form>
        <form method='post'>
        <button type="button" class="btn btn-default" id="vowel-audio">Pronounce Syllable</button>
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
        <td class="syllableCell deletedCell" id='cell-{{{ $colIndex }}}-{{{ $rowIndex }}}' colId="{{{$vowel['header_id']}}}" rowId="{{{$consonant['header_id']}}}" onclick='selectCell("{{{ $colIndex }}}", "{{{ $rowIndex }}}")'>
          <b>{{{ $consonant['ipa'] . $vowel['ipa'] }}}</b>
          <br>
          <div>
          </div>
        </td>
        <?php } ?>
        @endforeach
    </tr>
    @endforeach
</table>
