@extends('layouts.plain')
@section('head-custom')

@stop
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<main>

<audio id="audio-container-1"></audio>
<audio id="audio-container-2"></audio>
<div id="grid-div">
</div>

<script type='text/javascript'>
    var selectedRowId;
    var selectedColId;
    var openModal;
    // On load
    $(function() {
      loadGrid();
      selectedRowId = -1;
      selectedColid = -1;
      openModal = undefined;
    });

    function loadGrid()
    {
      // Ensure any open modals are closed first.
      closeOpenModal(function() {
        $("#grid-div").load("/syllabary/grid/1");
      });
    }

    function addColumnRight(ipa)
    {
      
      $.post("/syllabary/1/column/add/" + selectedColId, {"ipa": ipa}, function() {
        loadGrid();
      });
    }

    function addColumnLeft(ipa)
    {
      
      $.post("/syllabary/1/column/add/-" + selectedColId, {"ipa": ipa}, function() {
        loadGrid();
      });
    }

    function removeSelectedColumn()
    {
      
      if (selectedColId != -1) {
        $.post("/syllabary/1/column/" + selectedColId + "/remove", function() {
          loadGrid();
        });
      }
    }

    function addRowTop(ipa)
    {
      
      $.post("/syllabary/1/row/add/-" + selectedRowId, {"ipa": ipa}, function() {
        loadGrid();
      });
    }

    function addRowBottom(ipa)
    {
      
      $.post("/syllabary/1/row/add/" + selectedRowId, {"ipa": ipa}, function() {
        loadGrid();
      });
    }

    function removeSelectedRow()
    {
      
      if (selectedRowId != -1) {
        $.post("/syllabary/1/row/" + selectedRowId + "/remove", function() {
          loadGrid();
        });
      }
    }

    function uploadRowAudioSample(rowId)
    {
      var fd = new FormData($('#audioUpload-row-' + rowId)[0]);
      $.ajax({
        method: 'POST',
        url:  '/syllabary/1/row/' + rowId + '/uploadAudio',
        data: fd,
        cache: false,
        enctype: 'multipart/form-data',
        contentType: false,
        processData: false,
        success: function(data) {
          alert('Sample uploaded successfully!');
          loadGrid();
          
        },
      });
    }

    function uploadColumnAudioSample(colId)
    {
      alert("Uploaded to column " + colId);
    }

    function selectColumn(index)
    {
        selectedColId = $("#col-" + index).attr("colId");
        select("col-" + index);
		    openModal = $("#edit-column-modal-" + index);
            openModal.on('hide.bs.modal', function () {
            unselectAll();
            })
        openModal.modal('show');
    }

    function selectRow(index)
    {
        selectedRowId = $("#row-" + index).attr("rowId");
        select("row-" + index);
		    openModal = $("#edit-row-modal-" + index);
            openModal.on('hide.bs.modal', function () {
            unselectAll();
            })
        openModal.modal('show');
    }

    function selectCell(colIndex, rowIndex)
    {
       select("cell-" + colIndex + "-" + rowIndex);
		   openModal = $("#edit-symbol-modal-" + colIndex + "-" + rowIndex)
            openModal.on('hide.bs.modal', function () {
            unselectAll();
            })
       openModal.modal('show');
    }

    function unselectAll()
    {
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
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

    function closeOpenModal(callback)
    {
      if (openModal != undefined) {
        if (callback != undefined)
          openModal.one('hidden.bs.modal', callback);
        openModal.modal('hide');
      } else {
        if (callback != undefined)
          callback();
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
        }
        else if(document.getElementById(cell).className=='syllableCell-selected')
        {
            document.getElementById(cell).className = 'syllableCell';
            hide("row-controls");
            hide("col-controls");
            hide("cell-controls");
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

    function removeCell(rowId, colId)
    { 
      $.post("/syllabary/1/cell/" + rowId + "/" + colId + "/remove", function() {
        loadGrid();
      });
    }

    function restoreCell(rowId, colId)
    {
      
      $.post("/syllabary/1/cell/" + rowId + "/" + colId + "/restore", function() {
        loadGrid();
      });
    }

    function pronounceVowel(event, colId)
    {
      event.stopPropagation();
      // We append a date on the end as a cache-busting parameter, ensuring any new audio files are loaded
      // instead of cached ones.
      $('#audio-container-1').attr('src', '/syllabary/1/column/' + colId + '/getAudio?cb=' + new Date().getTime());
      $('#audio-container-1')[0].play();
    }

    function pronounceConsonant(event, rowId)
    {
      event.stopPropagation();
      // We append a date on the end as a cache-busting parameter, ensuring any new audio files are loaded
      // instead of cached ones.
      $('#audio-container-1').attr('src', '/syllabary/1/row/' + rowId + '/getAudio?cb=' + new Date().getTime());
      $('#audio-container-1')[0].play();
    }

    function pronounceSyllable(event, rowId, colId)
    {
      event.stopPropagation();
      $('#audio-container-1').attr('src', '/syllabary/1/row/' + rowId + '/getAudio?cb=' + new Date().getTime());
      $('#audio-container-2').attr('src', '/syllabary/1/column/' + rowId + '/getAudio?cb=' + new Date().getTime());

      $('#audio-container-1')[0].play();
      $('#audio-container-2')[0].play();
    }
    
    function editVowel(vowel)
    {
        var newVowel = prompt("Please enter the vowel", vowel);
        $.post("/syllabary/1/column/" + selectedColId + "/vowel/" + newVowel, function() {
          loadGrid();
        });
    }
    
    function editConsonant(consonant)
    {
        var newConsonant = prompt("Please enter the consonant", consonant);
        $.post("/syllabary/1/row/" + selectedRowId + "/consonant/" + newConsonant, function() {
          loadGrid();
        });
    }
</script>

	
</main>
@stop 
