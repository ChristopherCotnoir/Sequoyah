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
      <th <?php echo 'class="headerCell" onmouseover="show(\'' . $vowel['ipa'] . '\')" onmouseout="hide(\'' . $vowel['ipa'] . '\')">'; ?><b>{{{ $vowel['ipa'] }}} <br /> <?php echo $vowel['symbol']; ?> <br /><div align="center" style="height:25px"> <?php echo '<button type="button" id="' . $vowel['ipa'] . '" style="display:none">Edit Symbol</button>'; ?></div></b></th>
      <?php $starting_symbol++; ?>
    @endforeach
  </tr>

  @foreach($consonants as $consonant)
    <tr>
      <td <?php echo 'class="headerCell" onmouseover="show(\'' . $consonant['ipa'] . '\')" onmouseout="hide(\'' . $consonant['ipa'] . '\')">'; ?><b>{{{ $consonant['ipa'] }}}</b> <br /> <?php echo $consonant['symbol']; ?> <br /><div align="center" style="height:25px"> <?php echo '<button type="button" id="' . $consonant['ipa'] . '" style="display:none">Edit Symbol</button>'; ?></div></td>
      <?php $starting_symbol++; ?>
      @for($i = 0; $i < count($vowels); $i++)
        <td <?php echo 'class="syllableCell" onmouseover="show(\'' . $consonant['ipa'] . $vowels[$i]['ipa'] . '\')" onmouseout="hide(\'' . $consonant['ipa'] . $vowels[$i]['ipa'] . '\')">'; ?>{{{ $consonant['ipa'] . $vowels[$i]['ipa'] }}} <br />
          <svg width="100%" height="100%">
            <?php echo $consonant['symbol'] . "\n" . $vowels[$i]['symbol'];?>
			<br /><div align="center" style="height:25px"> <?php echo '<button type="button" id="' . $consonant['ipa'] . $vowels[$i]['ipa'] . '" style="display:none">Edit Symbol</button>'; ?></div>
          </svg>
        </td>
        <?php $starting_symbol++; ?>
      @endfor
    </tr>
  @endforeach
</table>

<script>
function show(button)
{
document.getElementById(button).style.display = 'block';
}
function hide(button)
{
document.getElementById(button).style.display = 'none';
}
</script>
</main>
@stop

