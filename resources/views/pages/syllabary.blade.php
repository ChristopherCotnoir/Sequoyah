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

    .syllableCell img {
    width: 100px;
    height: 100px;
    }

    #syllabaryGrid {
    width: 100%;
    font-size: 200%;
    }

    #col-controls,
    #row-controls {
    display: none;
    }

    .headerCell-selected {
    background: #C43;
    }

    .headerCell,
    .headerCell-selected {
    -webkit-transition:background-color 0.4s linear;
    -o-transition:background-color 0.4s linear;
    -moz-transition:background-color 0.4s linear;
    transition:background-color 0.4s linear;
    }
</style>
@stop
@section('content')
<main>

<div style="height:200px">
<!--===========================================================================================================
                                            Column Control Panel 
============================================================================================================-->
<div id="col-controls">
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default">Add Column Left</button>
    </form>
<!-- <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') }}}/remove'> -->
    <form method='post'>
    <button type="button" class="btn btn-default">Remove Column</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') + 1 }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default">Add Column Right</button>
    </form>
</div>

<!--===========================================================================================================
                                             Row Control Panel 
============================================================================================================-->
<div id="row-controls">
<!-- <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default">Add Row Left</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') }}}/remove'> -->
    <form method='post'>
    <button type="button" class="btn btn-default">Remove Row</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') + 1 }}}/add'> -->
    <form method='post'>
    <button type="button" class="btn btn-default">Add Row Right</button>
    </form>
</div>
</div>
<!--==========================================================================================================
                                               Syllabary Grid
===========================================================================================================-->
<table id='syllabaryGrid' border='1'>
    <tr>
        <th class='headerCell' onclick='hide("row-controls");hide("col-controls");unselect()'></th>
        @foreach($vowels as $colIndex => $vowel)
        <th class='headerCell' id='col-{{{ $colIndex }}}' onclick='show("col-controls");hide("row-controls");select("col-{{{ $colIndex }}}")'>
            <b>{{{ $vowel['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
        </th>
        @endforeach
    </tr>

    @foreach($consonants as $rowIndex => $consonant)
    <tr>
        <th class='headerCell' id='row-{{{ $rowIndex }}}' onclick='show("row-controls");hide("col-controls");select("row-{{{ $rowIndex }}}")'>
            <b>{{{ $consonant['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
        </th>
        @foreach($vowels as $colIndex => $vowel)
        <td onclick='hide("row-controls");hide("col-controls");unselect()'>
        {{{ $consonant['ipa'] . $vowel['ipa'] }}}
        </td>
        @endforeach
    </tr>
    @endforeach
</table>

<script type='text/javascript'>
    function show(panel)
    {
        document.getElementById(panel).style.display = 'block';
    }

    function hide(panel)
    {
        document.getElementById(panel).style.display = 'none';
    }

    function select(cell)
    {
        if(document.getElementById(cell).className=='headerCell-selected')
        {
            document.getElementById(cell).className = 'headerCell';
            hide("row-controls");
            hide("col-controls");
        }
        else
        {
            unselect();
            document.getElementById(cell).className = 'headerCell-selected';
        }
    }

    function unselect()
    {
        var selected = document.getElementsByClassName('headerCell-selected');
        for (var i = 0; i < selected.length; i++)
        {
            selected[i].className = 'headerCell';
        }
    }
    
    function editSymbol(symbolId)
    {
        window.location = '/svg-edit/svg-editor.html?symbol_id=' + symbolId;
    }
</script>
</main>
@stop