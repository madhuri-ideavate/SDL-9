(function ($) {

  $.fn.dataTableExt.oApi.fnGetColumnData = function (oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty) {
    // check that we have a column id
    if (typeof iColumn == "undefined") return new Array();

    // by default we only want unique data
    if (typeof bUnique == "undefined") bUnique = true;

    // by default we do want to only look at filtered data
    if (typeof bFiltered == "undefined") bFiltered = true;

    // by default we do not want to include empty values
    if (typeof bIgnoreEmpty == "undefined") bIgnoreEmpty = true;

    // list of rows which we're going to loop through
    var aiRows;

    // use only filtered rows
    if (bFiltered == true) aiRows = oSettings.aiDisplay;
    // use all rows
    else aiRows = oSettings.aiDisplayMaster; // all row numbers

    // set up data array
    var asResultData = new Array();

    for (var i = 0, c = aiRows.length; i < c; i++) {
      iRow = aiRows[i];
      var aData = this.fnGetData(iRow);
      var sValue = aData[iColumn];

      // ignore empty values?
      if (bIgnoreEmpty == true && sValue.length == 0) continue;

      // ignore unique values?
      else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;

      // else push the value onto the result data array
      else asResultData.push(sValue);
    }

    return asResultData;
  };

  function fnCreateSelect(aData, label, col) {
    var r = '<div class="filter-wrapper"><span class="filter-label">' + label + ': </span><select class="tablefilter" data-col="' + col + '"><option value=""></option>', i, iLen = aData.length;
    r += '<option value="" disabled selected>Select your option</option>';

    for (i = 0; i < iLen; i++) {
      r += '<option value="' + aData[i] + '">' + aData[i] + '</option>';
    }
    return r + '</select></div>';
  }

  Drupal.behaviors.jobOverview = {
    attach: function (context, settings) {
        var table = $.fn.dataTable.fnTables(true);
        if (table.length > 0) {
          var oTable = $(table).dataTable();
          /* Add a select menu for each TH element in the table footer */
          $("thead th").each(function (i) {
            var label = $(this).text();
            var filter = fnCreateSelect(oTable.fnGetColumnData(i), label, i);
            $(filter).appendTo('.clear');
            $('select.tablefilter').change(function () {
              var col = $(this).data('col');
              oTable.fnFilter($(this).val(), col);
            });
          });
        }
      if ($('.joboverview-table').length) {
        $('body').addClass('joboverview-table-page');
      }
    }
  };
})(jQuery);




