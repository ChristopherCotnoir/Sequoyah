@extends('layouts.plain')
@section('head-custom')

@stop
@section('content')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>





<main>
		

		
		
	<div id="grid-div">
		
	</div>

<script type='text/javascript'>
	
	
	
	
    var selectedRowId;
    var selectedColId;
    // On load
    $(function() {
      loadGrid();
      selectedRowId = -1;
      selectedColid = -1;
    });



	


    function loadGrid()
    {
      $("#grid-div").load("/syllabary/grid/1");
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

    function selectColumn(index)
    {
        /*selectedColId = $("#col-" + index).attr("colId");
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
        show("col-control-" + index);*/
        select("col-" + index);
		
		
		$("#edit-column-modal-" + index).modal('show')
    }

    function selectRow(index)
    {
       /* selectedRowId = $("#row-" + index).attr("rowId");
        hide("col-controls");
        hide("row-controls");
        hide("cell-controls");
        show("row-control-" + index); */
        select("row-" + index);
		
		$("#edit-row-modal-" + "index").modal('show');
    }

    function selectCell(colIndex, rowIndex)
    {
       // hide("col-controls");
       // hide("row-controls");
       // hide("cell-controls");
       // show("cell-control-" + colIndex + "-" + rowIndex);
        select("cell-" + colIndex + "-" + rowIndex);
		
		$("#edit-symbol-modal-" + colIndex + "-" + rowIndex).modal('show');
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
	
	
	

	
</script>

	
</main>





@stop 