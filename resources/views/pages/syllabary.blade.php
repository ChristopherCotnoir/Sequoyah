@extends('layouts.plain')
@section('head-custom')
<style>
    .headerCell {
    background: #BDC3C7;
    }

    .headerCell img {
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

    input[type="radio"],
    btn-group col-controls,
    btn-group row-controls {
    display: none;
    }

    .headerCell
    input[type="radio"] + .headerCell {
    background: #BDC3C7;
    }

    input[type="radio"]:checked + .headerCell {
    background: #C43;
    }

    input[type="radio"] + .headerCell,
    input[type="radio"]:checked + .headerCell {
    -webkit-transition:background-color 0.4s linear;
    -o-transition:background-color 0.4s linear;
    -moz-transition:background-color 0.4s linear;
    transition:background-color 0.4s linear;
    }
</style>
@stop
@section('content')
<main>

<!--===========================================================================================================
                                            Column Control Panel 
============================================================================================================-->
<div class="btn-group col-controls" role="group" aria-label="...">
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') }}}/add'> -->
    <form method='post'>
    <button type="submit" class="btn btn-default">Add Column Left</button>
    </form>
<!-- <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') }}}/remove'> -->
    <form method='post'>
    <button type="submit" class="btn btn-default">Remove Column</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/column/{{{ Request::input('columnIndex') + 1 }}}/add'> -->
    <form method='post'>
    <button type="submit" class="btn btn-default">Add Column Right</button>
    </form>
</div>

<!--===========================================================================================================
                                             Row Control Panel 
============================================================================================================-->
<div class="btn-group row-controls" role="group" aria-label="...">
<!-- <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') }}}/add'> -->
    <form method='post'>
    <button type="submit" class="btn btn-default">Add Row Left</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') }}}/remove'> -->
    <form method='post'>
    <button type="submit" class="btn btn-default">Remove Row</button>
    </form>
<!--  <form method='post' action='syllabary/{{--{{{ $syllabaryId }}}--}}/row/{{{ Request::input('rowIndex') + 1 }}}/add'> -->
    <form method='post'>
    <button type="submit" class="btn btn-default">Add Row Right</button>
    </form>
</div>

<!--==========================================================================================================
                                               Syllabary Grid
===========================================================================================================-->
<table id='syllabaryGrid' border='1'>
    <tr>
        <th class='headerCell'></th>
        @foreach($vowels as $colIndex => $vowel)
        <input type='radio' id='col-{{{ $colIndex }}}' value='{{{ $colIndex }}}' name='columnIndex'>
        <th class='headerCell' for='col-{{{ $colIndex }}}'>
            <b>{{{ $vowel['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $vowel['symbol_id'] }}}/data"></img>
        </th>
        @endforeach
    </tr>

    @foreach($consonants as $rowIndex => $consonant)
    <tr>
    <input type='radio' id='row-{{{ $rowIndex }}}' value='{{{ $rowIndex }}}' name='rowIndex'>
        <th class='headerCell' for='row-{{{ $rowIndex }}}'>
            <b>{{{ $consonant['ipa'] }}}</b>
            <br>
            <img src="/syllabary/symbol/{{{ $consonant['symbol_id'] }}}/data"></img>
        </th>
        @foreach($vowels as $colIndex => $vowel)
        <td>
        {{{ $consonant['ipa'] . $vowel['ipa'] }}}
        </td>
        @endforeach
    </tr>
    @endforeach
</table>

<script type='text/javascript'>
    function show(button)
    {
        document.getElementById(button).style.display = 'block';
    }

    function hide(button)
    {
        document.getElementById(button).style.display = 'none';
    }

    function editSymbol(symbolId)
    {
        window.location = '/svg-edit/svg-editor.html?symbol_id=' + symbolId;
    }

    $(function()
    {
        if($('input[name=rowIndex]').is(':checked'))
        {
            $('.btn-group .row-controls').style.display = 'block';
        }
        else
        {
            $('.btn-group .row-controls').style.display = 'show';
        };
        if($('input[name=colIndex]').is(':checked'))
        {
            $('.btn-group .col-controls').style.display = 'block';
        }
        else
        {
            $('.btn-group .col-controls').style.display = 'show';
        };
    });
</script>
</main>
@stop