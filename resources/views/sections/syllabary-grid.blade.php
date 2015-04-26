<!--===========================================================================================================
Column Control Panel 
============================================================================================================-->

@foreach($vowels as $colIndex => $vowel)
<div id="edit-column-modal-{{ $colIndex }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Vowel &lsquo;{{ $vowel['ipa'] }}&rsquo;</h4>
            </div>
            <div class="modal-body">

                <button type="button" class="green" data-dismiss="modal" onclick="addColumnLeft('')">Add Column Before</button>
                <button type="button" class="red" data-dismiss="modal" onclick="removeSelectedColumn()">Remove Column</button>
                <button type="button" class="green" data-dismiss="modal" onclick="addColumnRight('')">Add Column After</button>
                <button type="button" class="yellow" onclick="editVowel('{{ $vowel['ipa'] }}')">Edit Vowel</button>
                <button type="button" class="blue" data-dismiss="modal" onclick="editSymbol('{{ $vowel['symbol_id'] }}')">Edit Symbol</button>
                @if ($vowel['audio_sample'] != null)
                    <a class="red button" href="/syllabary/1/column/{{ $vowel['header_id'] }}/removeAudio">Remove Audio</a>
                @endif
                <form action="/syllabary/1/column/{{ $vowel['header_id'] }}/uploadAudio" method="post" enctype="multipart/form-data">
                    <label for="audioSample">Select Audio</label>
                    <input name="audioSample" type="file">
                    <button type="submit" class="float-right">Upload Audio</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="red" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endforeach

<!--===========================================================================================================
Row Control Panel 
============================================================================================================-->
@foreach($consonants as $rowIndex => $consonant)
<div id="edit-row-modal-{{ $rowIndex }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Consonant &lsquo;{{ $consonant['ipa'] }}&rsquo;</h4>
            </div>
            <div class="modal-body">

                <button type="button" class="green" data-dismiss="modal" onclick="addRowTop('')">Add Row Above</button>
                <button type="button" class="red" data-dismiss="modal" onclick="removeSelectedRow()">Remove Row</button>
                <button type="button" class="green" data-dismiss="modal" onclick="addRowBottom('')">Add Row Below</button>
                <button type="button" class="yellow" onclick="editConsonant('{{ $consonant['ipa'] }}')">Edit Consonant</button>
                <button type="button" class="blue" data-dismiss="modal" onclick="editSymbol('{{ $consonant['symbol_id'] }}')">Edit Symbol</button>
                @if ($consonant['audio_sample'] != null)
                    <a class="red button" href="/syllabary/1/row/{{ $consonant['header_id'] }}/removeAudio">Remove Audio</a>
                @endif
                <form action="/syllabary/1/row/{{ $consonant['header_id'] }}/uploadAudio" method="post" enctype="multipart/form-data">
                    <label for="audioSample">Select Audio</label>
                    <input name="audioSample" type="file">
                    <button type="submit" class="float-right">Upload Audio</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="red" data-dismiss="modal">Close</button>
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
<div id="edit-symbol-modal-{{ $colIndex }}-{{ $rowIndex }}" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Cell &lsquo;{{ $consonant['ipa'] }}{{ $vowel['ipa'] }}&rsquo;</h4>
            </div>
            <div class="modal-body">

                <button type="button" class="red" data-dismiss="modal" onclick="removeCell({{ $consonant['header_id'] }}, {{ $vowel['header_id'] }})">Remove Cell</button>
                <button type="button" class="" data-dismiss="modal" onclick="restoreCell({{ $consonant['header_id'] }}, {{ $vowel['header_id'] }})">Restore Cell</button>
                <button type="button" class="blue" data-dismiss="modal">Edit Symbol</button>

            </div>
            <div class="modal-footer">
                <button type="button" class="red" data-dismiss="modal">Close</button>
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
        <th class='headerCell' id='col-{{ $colIndex }}' colId="{{$vowel['header_id']}}" onclick='selectColumn("{{ $colIndex }}")'>
            @if ($vowel['audio_sample'] != NULL)
            <img class="sampleBtn" src="/images/speaker.png" onclick="pronounceVowel(event, '{{ $vowel['header_id'] }}')"></img>
            @endif
            <b>{{ $vowel['ipa'] }}</b>
            <br>
            <img src="/syllabary/symbol/{{ $vowel['symbol_id'] }}/data"></img>
        </th>
        @endforeach
    </tr>

    @foreach($consonants as $rowIndex => $consonant)
    <tr>
        <th class='headerCell' id='row-{{ $rowIndex }}' rowId="{{$consonant['header_id']}}" onclick='selectRow("{{ $rowIndex }}")'>
            @if ($consonant['audio_sample'] != NULL)
            <img class="sampleBtn" src="/images/speaker.png" onclick="pronounceConsonant(event, '{{ $consonant['header_id'] }}')"></img>
            @endif
            <b>{{ $consonant['ipa'] }}</b>
            <br>
            <img src="/syllabary/symbol/{{ $consonant['symbol_id'] }}/data"></img>
        </th>
        @foreach($vowels as $colIndex => $vowel)
        <?php
        if (isset($cells[$consonant['header_id']][$vowel['header_id']])) {
            $cell = $cells[$consonant['header_id']][$vowel['header_id']];
            $cellDeleted = $cell->deleted;
            $cellSymbolId = $cell->symbol_id;
        } else {
            $cellDeleted = false;
            unset($cellSymbolId);
        }
        ?>

        <?php if (!$cellDeleted) { ?>
        <td class="syllableCell" id='cell-{{ $colIndex }}-{{ $rowIndex }}' colId="{{$vowel['header_id']}}" rowId="{{$consonant['header_id']}}" onclick='selectCell("{{ $colIndex }}", "{{ $rowIndex }}")'>
            @if ($consonant['audio_sample'] != NULL && $vowel['audio_sample'] != NULL)
            <img class="sampleBtn" src="/images/speaker.png" onclick="pronounceSyllable(event, '{{ $consonant['header_id'] }}', '{{ $vowel['header_id'] }}')"></img>
            @endif
            <b>{{ $consonant['ipa'] . $vowel['ipa'] }}</b>
            <br>
            <div>
                @if (isset($cellSymbolId) && $cellSymbolId != NULL)
                <img src="/syllabary/symbol/{{ $cellSymbolId }}/data"></img>
                @else
                <img src="/syllabary/symbol/{{ $consonant['symbol_id'] }}/data"></img>
                <img src="/syllabary/symbol/{{ $vowel['symbol_id'] }}/data"></img>
                @endif
            </div>
        </td>
        <?php } else { ?>
        <td class="syllableCell" id='cell-{{ $colIndex }}-{{ $rowIndex }}' colId="{{$vowel['header_id']}}" rowId="{{$consonant['header_id']}}" onclick='selectCell("{{ $colIndex }}", "{{ $rowIndex }}")'>
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
