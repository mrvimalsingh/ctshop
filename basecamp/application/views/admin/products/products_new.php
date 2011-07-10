<style>
    .styleTable { border-collapse: separate; }
    .styleTable TD { font-weight: normal !important; padding: .4em; border-top-width: 0px !important; }
    .styleTable TH { text-align: center; padding: .8em .4em; }
    .styleTable TD.first, .styleTable TH.first { border-left-width: 0px !important; }
</style>
<script>
    (function ($) {
        $.fn.styleTable = function (options) {
            var defaults = {
                css: 'styleTable ui-widget ui-widget-content ui-corner-all'
            };
            options = $.extend(defaults, options);

            return this.each(function () {

                input = $(this);
                input.addClass(options.css);

                input.find("tr").live('mouseover mouseout', function (event) {
                    if (event.type == 'mouseover') {
                        $(this).children("td").addClass("ui-state-hover");
                    } else {
                        $(this).children("td").removeClass("ui-state-hover");
                    }
                });

                input.find("th").addClass("ui-state-default");
                input.find("td").addClass("ui-widget-content");

                input.find("tr").each(function () {
                    $(this).children("td:not(:first)").addClass("first");
                    $(this).children("th:not(:first)").addClass("first");
                });
            });
        };
    })(jQuery);

    $(document).ready(function () {
        $("#myTable").styleTable();
    });
</script>

<div class="ui-grid-header ui-widget-header ui-corner-top" style="padding: 5px">jQuery UI Grid Header</div>
<table id="myTable" width="100%" class="">
    <thead>
    <tr>
        <th>Column 1</th>
        <th>Column 2</th>
        <th>Column 3</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>Row 0 Column 0</td>
        <td >Row 0 Column 1</td>
        <td >Row 0 Column 2</td>
    </tr>
    <tr >
        <td>Row 1 Column 0</td>
        <td>Row 1 Column 1</td>
        <td>Row 1 Column 2</td>
    </tr>
    <tr >
        <td>Row 2 Column 0</td>
        <td>Row 2 Column 1</td>
        <td>Row 2 Column 2</td>
    </tr>
    </tbody>
</table>
<div class="ui-grid-header ui-widget-header ui-corner-bottom" style="padding: 5px">jQuery UI Grid Header</div>