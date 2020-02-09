var database = firebase.database();
$(document).ready(function () {
    var total = $("#totalChat");
    total.hide();
    var cont = 0;

    /*VERIFICA SE NOTIFICAÇÕES É PERMITIDO*/
    var notifica = false;
    if (window.Notification && Notification.permission !== "denied") {
        notifica = true;
        console.log("Tudo permitido");
    } else {
        console.log("Sem permissão");
    }
    function escreveNotificacao(mensagem) {
        if (notifica) {
            Notification.requestPermission(function (status) {

                let n = new Notification('Nova mensagem no Chat', {
                    body: mensagem
                });
                n.onclick = function(){
                    window.open('https://jrnet.pyxissoftware.com.br/chat', '_self');
                };
            });
        }
    }

    function getNotificacoes() {
        var starCountRef = database.ref('notificacoes/');
        cont = 0;
        starCountRef.on('value', function (snapshot) {
            snapshot.forEach(function (item) {
                var dados = item.val();
                console.log("Para: " + dados.para);
                if (dados.para == "JRNET") {
                    cont++;
                    escreveNotificacao(dados.mensagem);
                    starCountRef.child(item.key).remove();
                }
            });
            if(cont > 0){
                total.html('');
                total.html(cont);
                total.fadeIn(200);
            }
        });
    }
    getNotificacoes();
});