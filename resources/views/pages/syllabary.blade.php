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

  .headerCell svg {
    width:100px;
    height:100px;
  }

  .syllableCell svg {
    width: 100px;
    height: 100px;
  }
</style>
@stop

@section('content')
<main>
<table id='syllabaryGrid' border='1'>
  <tr>
    <th class='headerCell'></th>
    @foreach($vowels as $vowel)
      <th class='headerCell'><b>{{{ $vowel['ipa'] }}} <br /> <?php echo $vowel['symbol']; ?></b></th>
      <?php $starting_symbol++; ?>
    @endforeach
  </tr>

  @foreach($consonants as $consonant)
    <tr>
      <td class='headerCell'><b>{{{ $consonant['ipa'] }}}</b> <br /> <?php echo $consonant['symbol']; ?></td>
      <?php $starting_symbol++; ?>
      @for($i = 0; $i < count($vowels); $i++)
        <td class='syllableCell'>{{{ $consonant['ipa'] . $vowels[$i]['ipa'] }}} <br />
          <svg width="100%" height="100%">
            <?php echo $consonant['symbol'] . "\n" . $vowels[$i]['symbol'];?>
          </svg>
        </td>
        <?php $starting_symbol++; ?>
      @endfor
    </tr>
  @endforeach
</table>

</main>
@stop

