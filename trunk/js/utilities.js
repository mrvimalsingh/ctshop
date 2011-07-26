function applyJqueryStyle() {
    $("fieldset").addClass("ui-widget-content ui-corner-all");
    $("fieldset").attr("style", "margin: 5px");
    $("legend").addClass("ui-corner-all ui-widget-header");
    $("legend").attr("style", "padding: 5px");

    $('.fancy_table').addClass('ui-widget');
    $('.fancy_table th').addClass('ui-widget-header');
    $('.fancy_table td').addClass('ui-widget-content');

    $('.fancy_table th:first').addClass('ui-corner-tl');
    $('.fancy_table th:last').addClass('ui-corner-tr');

    $('.fancy_menu').addClass("ui-widget ui-widget-content ui-corner-tr ui-corner-br ui-state-default");
    $('.fancy_menu li').addClass("ui-state-default");
    $('.fancy_menu li:first').addClass("ui-corner-tr");
    $('.fancy_menu li:last').addClass("ui-corner-br");
    $('.fancy_menu li').hover(
            function(){
                $(this).addClass("ui-state-hover");
            },
            function(){
                $(this).removeClass("ui-state-hover");
            }
    )



}