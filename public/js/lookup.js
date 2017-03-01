/**
 * Created by Yuri on 01/03/2017.
 */
$(".lookup").fcbkcomplete({
    json_url: "public/tmp/tmpLookupData.txt",
    addontab: true,
    maxitems: 10,
    input_min_size: 0,
    height: 10,
    cache: false,
    newel: true,
    select_all_text: "select",
});
var delay = (function(){
    var timer = 0;
    return function(callback, ms){
        clearTimeout (timer);
        timer = setTimeout(callback, ms);
    };

})();
$(document).on("keyup", ".maininput", function() {
    delay(function(){
        $.get("runtime/lib/searchLookup.php", {busca: $(".maininput").val(), lookupTabela: $("#lookupTabela").val(), lookupCampo: $("#lookupCampo").val()}, function(result){
            console.log(result)
//                                alert($(".maininput").val());
        });
    }, 500 );
});
