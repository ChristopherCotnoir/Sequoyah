@extends('layouts.plain')
@section ('head-custom')
<style type='text/css'>
  #syllabaryGrid {
    width: 100%;
    font-size: 200%;
  }

  .headerCell {
    background: #BDC3C7;
  }
</style>
@stop

@section('content')
<main>
<table id='syllabaryGrid' border='1'>
  <tr>
    <th class='headerCell'></th>
    @foreach($vowels as $vowel)
      <th class='headerCell'><b>{{{ $vowel }}} <br /> {{ '&#x' . dechex($starting_symbol) }}</b></th>
      <?php $starting_symbol++; ?>
    @endforeach
  </tr>

  @foreach($consonants as $consonant)
    <tr>
      <td class='headerCell'><b>{{{ $consonant }}}</b> <br /> {{ '&#x' . dechex($starting_symbol) }}</td>
      <?php $starting_symbol++; ?>
      @for($i = 0; $i < count($vowels); $i++)
        <td>{{{ $consonant . $vowels[$i] }}} <br /> {{ '&#x' . dechex($starting_symbol) }}</td>
        <?php $starting_symbol++; ?>
      @endfor
    </tr>
  @endforeach
</table>
</main>
@stop

