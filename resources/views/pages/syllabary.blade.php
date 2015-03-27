@extends('layouts.plain')
@section ('head-custom')
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
</style>
@stop

@section('content')
<main>
<table id='syllabaryGrid' border='1'>
  <tr>
    <th class='headerCell'></th>
    @foreach($vowels as $vowel)
      <th <?php echo 'class="headerCell" onmouseover="show(\'' . $vowel['ipa'] . '\')" onmouseout="hide(\'' . $vowel['ipa'] . '\')">'; ?><b>{{{ $vowel['ipa'] }}} <br /><img src='<?php echo "/syllabary/symbol/$vowel[symbol_id]/data"; ?>'></img><br /><div align="center" style="height:25px"> <?php echo '<button type="button" class="edit-button" id="' . $vowel['ipa'] . '" style="display:none" onclick="editSymbol(\'' . $vowel['symbol_id'] . '\')">Edit Symbol</button>'; ?></div></b></th>
    @endforeach
  </tr>

  @foreach($consonants as $consonant)
    <tr>
      <td <?php echo 'class="headerCell" onmouseover="show(\'' . $consonant['ipa'] . '\')" onmouseout="hide(\'' . $consonant['ipa'] . '\')">'; ?><b>{{{ $consonant['ipa'] }}}</b> <br /><img src='<?php echo "/syllabary/symbol/$consonant[symbol_id]/data"; ?>'></img><br /><div align="center" style="height:25px">
        <?php echo '<button type="button" class="edit-button" id="' . $consonant['ipa'] . '" style="display:none" onclick="editSymbol(\'' . $consonant['symbol_id'] . '\')">Edit Symbol</button>'; ?></div></td>
      @for($i = 0; $i < count($vowels); $i++)
	  
         <td <?php echo 'class="syllableCell" onmouseover="show(\'' . $consonant['ipa'] . $vowels[$i]['ipa'] . '\')" 			onmouseout="hide(\'' . $consonant['ipa'] . $vowels[$i]['ipa'] . '\')">'; ?>
          {{{ $consonant['ipa'] . $vowels[$i]['ipa'] }}}
          <br />
         </td> 	
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
i}

function editSymbol(symbolId)
{
  window.location='/svg-edit/svg-editor.html?symbol_id=' + symbolId;
}
</script>
</main>
@stop

