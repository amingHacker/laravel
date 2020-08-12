// Script to fix column's height are different after enable frozen column feature
var fixPositionsOfFrozenDivs = function () {
    var $rows;
    if (this.grid.fbDiv !== undefined) {
        $rows = $('>div>table.ui-jqgrid-btable>tbody>tr', this.grid.bDiv);
        $('>table.ui-jqgrid-btable>tbody>tr', this.grid.fbDiv).each(function (i) {
            var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
            if ($(this).hasClass("jqgrow")) {
                $(this).height(rowHight);
                rowHightFrozen = $(this).height();
                if (rowHight !== rowHightFrozen) {
                    $(this).height(rowHight + (rowHight - rowHightFrozen));
                }
            }
        });
        $(this.grid.fbDiv).height(this.grid.bDiv.clientHeight);
        $(this.grid.fbDiv).css($(this.grid.bDiv).position());
    }
    if (this.grid.fhDiv !== undefined) {
        $rows = $('>div>table.ui-jqgrid-htable>thead>tr', this.grid.hDiv);
        $('>table.ui-jqgrid-htable>thead>tr', this.grid.fhDiv).each(function (i) {
            var rowHight = $($rows[i]).height(), rowHightFrozen = $(this).height();
            $(this).height(rowHight);
            rowHightFrozen = $(this).height();
            if (rowHight !== rowHightFrozen) {
                $(this).height(rowHight + (rowHight - rowHightFrozen));
            }
        });
        $(this.grid.fhDiv).height(this.grid.hDiv.clientHeight);
        $(this.grid.fhDiv).css($(this.grid.hDiv).position());
    }
};