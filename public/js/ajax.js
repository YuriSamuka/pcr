/**
 * Created by Yuri on 18/02/2017.
 */

// $("#button_nome").click(function() {
//     alert('js jquery funfando no 12!!')
// });

// $("#button_nome").click(function() {
//     var request  = $.ajax({
//         type: "POST", /* tipo post */
//         url: "index.php?form=rf_test", /* endereço do script PHP */
//         async: true,
//         data: "form=rf_test", /* informa Url */
//         success: function(data) { /* sucesso */
//             console.log("ta funfando??");
//             /* pode ser utilizado um alert para ver o retorno */
//             // $('#t').html(data); /* imprime o retorno no HTML */
//         },
//         beforeSend: function() { /* antes de enviar */
//             $('.loading').fadeIn('fast'); /* mostra o loading */
//         },
//         complete: function(){ /* completo */
//             $('.loading').fadeOut('fast'); /* esconde o loading */
//         }
//     });
//     request.done(function(resposta) {
//         console.log(resposta)
//     });
//
//     request.fail(function(jqXHR, textStatus) {
//         console.log("Request failed: " + textStatus);
//     });
// });


$(".btn").click(function() {
    var acao = $(this).attr("name");

    if ($("#irPara").length){
        form = $("#irPara").val();
    } else {
        form = $(".form").attr("name");
    }
    alert("formulario = "+form+" ação = "+acao);
    data = $( ".form" ).serialize();
    data += "&acao="+acao+"&form="+form;
    console.log(data);
    $.get("runtime/lib/formFlow.php", data, function(result){
        console.log(result)
        $("#panelContent").remove();
        $("#bodyContent").html(result);
    });
});

