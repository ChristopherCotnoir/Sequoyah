@extends('layouts.plain')
@section('head-custom')

@stop
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<main>

<audio id="audio-container"></audio>
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
      $("#grid-div").load("/syllabary/grid/1");
    }

    function addColumnRight(ipa)
    {
      $.post("/syllabary/1/column/add/" + selectedColId, {"ipa": ipa}, function() {
        loadGrid();
        closeOpenModal();
      });
    }

    function addColumnLeft(ipa)
    {
      $.post("/syllabary/1/column/add/-" + selectedColId, {"ipa": ipa}, function() {
        loadGrid();
        closeOpenModal();
      });
    }

    function removeSelectedColumn()
    {
      if (selectedColId != -1) {
        $.post("/syllabary/1/column/" + selectedColId + "/remove", function() {
          loadGrid();
          closeOpenModal();
        });
      }
    }

    function addRowTop(ipa)
    {
      $.post("/syllabary/1/row/add/-" + selectedRowId, {"ipa": ipa}, function() {
        loadGrid();
        closeOpenModal();
      });
    }

    function addRowBottom(ipa)
    {
      $.post("/syllabary/1/row/add/" + selectedRowId, {"ipa": ipa}, function() {
        loadGrid();
        closeOpenModal();
      });
    }

    function removeSelectedRow()
    {
      if (selectedRowId != -1) {
        $.post("/syllabary/1/row/" + selectedRowId + "/remove", function() {
          loadGrid();
          closeOpenModal();
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
          closeOpenModal();
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
        openModal.modal('show');
    }

    function selectRow(index)
    {
        selectedRowId = $("#row-" + index).attr("rowId");
        select("row-" + index);
		    openModal = $("#edit-row-modal-" + index);
        openModal.modal('show');
    }

    function selectCell(colIndex, rowIndex)
    {
       select("cell-" + colIndex + "-" + rowIndex);
		   openModal = $("#edit-symbol-modal-" + colIndex + "-" + rowIndex)
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

    function closeOpenModal()
    {
      if (openModal != undefined)
        openModal.modal('hide');
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
        closeOpenModal();
      });
    }

    function restoreCell(rowId, colId)
    {
      $.post("/syllabary/1/cell/" + rowId + "/" + colId + "/restore", function() {
        loadGrid();
        closeOpenModal();
      });
    }

    function pronounceVowel(colId)
    {
      // We append a date on the end as a cache-busting parameter, ensuring any new audio files are loaded
      // instead of cached ones.
      $('#audio-container').attr('src', '/syllabary/1/column/' + colId + '/getAudio?cb=' + new Date().getTime());
      $('#audio-container')[0].play();
    }

    function pronounceConsonant(rowId)
    {
      // We append a date on the end as a cache-busting parameter, ensuring any new audio files are loaded
      // instead of cached ones.
      $('#audio-container').attr('src', '/syllabary/1/row/' + rowId + '/getAudio?cb=' + new Date().getTime());
      $('#audio-container')[0].play();
    }
</script>

	
</main>
@stop 
