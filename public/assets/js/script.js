function encurtar(url) {
    var getUrl = "/?c=encurtar";

    // Excuta o AJAX para encurtar a URL
    $.ajax({
        type: "GET",
        url: getUrl,
        data: {url: url},
        dataType: "json",
        success: exibirResultado
    });
}

// Trata o resultado retornado via AJAX
function exibirResultado(value) {
    var tag = value['url_encurtada'];
    var p = $(".url-encurtada p");

    // Exibe a div que mostra o resultado da URL encurtada
    $(".url-encurtada").fadeIn('slow');

    if (tag.length > 0) {
        var url = window.location.host + "/?c=acessar&url=" + tag;
        var urlDetalhes = window.location.host + "/?c=detalhes&url=" + tag;
        
        var data = "A URL encurtada é: <b><a target='_new' href='http://" + url + "'>" + url + "</a></b><br />";
        data += "<small>Para detalhes da URL, acesse:  <a href='http://" + urlDetalhes + "'>" + urlDetalhes + "<b></b></a></small>";
        p.html(data);
    } else {
        p.html('Houve um erro ao encurtar a URL. Tente novamente.');
    }
}

// Função para codificar a URL
function urlencode(str) {
    str = (str + '').toString();
    return encodeURIComponent(str)
        .replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28')
        .replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
}

// Ao carregar o documento
$(document).ready(function () {

    // Ao clicar no botão encurtar
    $(".encurtar").click(function () {
        var url = $('.url').val();

        // Valida se a URL é válida.
        if (/^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url)) {
            $(".url-encurtada").fadeOut('slow');
            encurtar(url);
        } else {
            alert('Insira uma URL válida, por exemplo: "http://google.com"');
        }
    });

});