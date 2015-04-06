@extends('layouts.plain')
@section('head-custom')
<style>
    .headerCell {
    background: #BDC3C7;
    }

    .headerCell img, .headerCell-selected img {
    width:100px;
    height:100px;
    }

    .syllableCell {
    background: #FFFFFF;
    }

    .syllableCell img, .syllableCell-selected img {
    width: 100px;
    height: 100px;
    }

    .syllabaryGrid {
    width: 100%;
    font-size: 200%;
    }

    .col-controls,
    .row-controls,
    .cell-controls,
    .gen-controls {
    display: none;
    }

    .headerCell-selected, .syllableCell-selected {
    background: #C43;
    }

    .headerCell,
    .headerCell-selected,
    .syllableCell,
    .syllableCell-selected {
    -webkit-transition:background-color 0.4s linear;
    -o-transition:background-color 0.4s linear;
    -moz-transition:background-color 0.4s linear;
    transition:background-color 0.4s linear;
    }
</style>
@stop
@section('content')
<main>

<div style="height:400px">
<!--===========================================================================================================
                                            Column Control Panel 
============================================================================================================-->
@foreach($vowels as $colIndex => $vowel)
<div class="col-controls" id="col-control-{{{ $colIndex }}}">
    <form method='post'>
    <button type="button" class="btn btn-default">Add Column Left</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Remove Column</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Add Column Right</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Edit Vowel</button>
    </form>
</div>
@endforeach

<!--===========================================================================================================
                                             Row Control Panel 
============================================================================================================-->
@foreach($consonants as $rowIndex => $consonant)
<div class="row-controls" id="row-control-{{{ $rowIndex }}}">
    <form method='post'>
    <button type="button" class="btn btn-default">Add Row Above</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Remove Row</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Add Row Below</button>
    </form>
    <form method='post'>
    <button type="button" class="btn btn-default">Edit Consonant</button>
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
        <button type="button" class="btn btn-default">Remove Symbol</button>
        </form>
        <form method='post'>
        <button type="button" class="btn btn-default">Restore Symbol</button>
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
        <th class='headerCell' id='col-{{{ $colIndex }}}' onclick='selectColumn("{{{ $colIndex }}}")'>
            <b>{{{ $vowel['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
        </th>
        @endforeach
    </tr>

    @foreach($consonants as $rowIndex => $consonant)
    <tr>
        <th class='headerCell' id='row-{{{ $rowIndex }}}' onclick='selectRow("{{{ $rowIndex }}}")'>
            <b>{{{ $consonant['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
        </th>
        @foreach($vowels as $colIndex => $vowel)
        <td class="syllableCell" id='cell-{{{ $colIndex }}}-{{{ $rowIndex }}}' onclick='selectCell("{{{ $colIndex }}}", "{{{ $rowIndex }}}")'>
        {{{ $consonant['ipa'] . $vowel['ipa'] }}}
        </td>
        @endforeach
    </tr>
    @endforeach
</table>

<script type='text/javascript'>
    function selectColumn(index)
    {
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
        hide("gen-controls");
        show("col-control-" + index);
        show("gen-control-col-" + index);
        select("col-" + index)
    }

    function selectRow(index)
    {
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
        hide("gen-controls");
        show("row-control-" + index);
        show("gen-control-row-" + index);
        select("row-" + index)
    }

    function selectCell(colIndex, rowIndex)
    {
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
        hide("gen-controls");
        show("cell-control-" + colIndex + "-" + rowIndex);
        show("gen-control-cell-" + colIndex + "-" + rowIndex);
        select("cell-" + colIndex + "-" + rowIndex)
    }

    function unselectAll()
    {
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
        hide("gen-controls");
        unselect()
    }

    function show(panel)
    {
        document.getElementById(panel).style.display = 'block';
    }

    function hide(panels)
    {
        var selected = document.getElementsByClassName(panels);
        for (var i = 0; i < selected.length; i++)
        {
            selected[i].style.display = 'none';
        }
    }

    function select(cell)
    {
        if(document.getElementById(cell).className=='headerCell-selected')
        {
            document.getElementById(cell).className = 'headerCell';
            hide("row-controls");
            hide("col-controls");
            hide("cell-controls");
            hide("gen-controls");
        }
        else if(document.getElementById(cell).className=='syllableCell-selected')
        {
            document.getElementById(cell).className = 'syllableCell';
            hide("row-controls");
            hide("col-controls");
            hide("cell-controls");
            hide("gen-controls");
        }
        else
        {
            unselect();
            if(document.getElementById(cell).className=='headerCell')
            {
                document.getElementById(cell).className = 'headerCell-selected';
            }
            if(document.getElementById(cell).className=='syllableCell')
            {
                document.getElementById(cell).className = 'syllableCell-selected';
            }
        }
    }

    function unselect()
    {
        var selected = document.getElementsByClassName('headerCell-selected');
        for (var i = 0; i < selected.length; i++)
        {
            selected[i].className = 'headerCell';
        }
        var selected = document.getElementsByClassName('syllableCell-selected');
        for (var i = 0; i < selected.length; i++)
        {
            selected[i].className = 'syllableCell';
        }
    }

    function editSymbol(symbolId)
    {
        window.location = '/svg-edit/svg-editor.html?symbol_id=' + symbolId;
    }
</script>
</main>
@stop