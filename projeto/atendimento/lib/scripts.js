// JavaScript
// Wrap the native DOM audio element play function and handle any autoplay errors
Audio.prototype.play = (function(play) {
return function () {
  var audio = this,
      args = arguments,
      promise = play.apply(audio, args);
  if (promise !== undefined) {
    promise.catch(_ => {
      // Autoplay was prevented. This is optional, but add a button to start playing.
      var el = document.createElement("button");
      el.innerHTML = "Play";
      el.addEventListener("click", function(){play.apply(audio, args);});
      this.parentNode.insertBefore(el, this.nextSibling)
    });
  }
};
})(Audio.prototype.play);


var senhaAtualNome   = $("#senhaAtualNome");
var senhaAtualGuiche  = $("#senhaAtualGuiche");

var ultimaSenhaNome1   = $("#ultimaSenhaNome1");
var ultimaSenhaGuiche1  = $("#ultimaSenhaGuiche1");
var ultimaSenhaNome2   = $("#ultimaSenhaNome2");
var ultimaSenhaGuiche2  = $("#ultimaSenhaGuiche2");
var ultimaSenhaNome3   = $("#ultimaSenhaNome3");
var ultimaSenhaGuiche3  = $("#ultimaSenhaGuiche3");

var chamadoAtual = JSON.parse('{"id":null,"nome":null,"preferencial":null,"entrada":null,"qtd_chamadas":null,"atendido":null,"servico":null,"chamar":null,"ultima_chamada":null,"excluir":null,"status":true,"msg":null}');


//const audioChamada = document.getElementById('audioChamada');
//$("#audioChamada");
var cont = 0;

function getProximo() {
    //$("#fila").html('Atualizando...');
    
    $.get( "../get_proximo_painel.php")
    .done(function(data) {
        var resp = JSON.parse(data);
        if(resp.id != chamadoAtual.id && resp.qtd_chamadas > chamadoAtual.qtd_chamadas){
            chamadoAtual = resp;
            console.log(chamadoAtual);
            $("#senhaAtualNome").html(resp.nome);
            //console.log(senhaAtualNome.html());
            //senhaAtualGuiche.html(resp.ultima_chamada);
	     $("#senhaAtualGuiche").html(resp.ultima_chamada);
	     //$("#audioChamada").play();
            document.getElementByI('audioChamada').play()
		//audioChamada.play();
        }
        cont++;
        console.log(cont);
    });

}
setInterval(getProximo, 10000);
