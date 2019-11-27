var database = firebase.database();
$(document).ready(function () {
    /*CRIANDO OBJETOS DA PÁGINA*/
    var telaUsuserios = $("#colectionUsers");
    var CPF_CONVERSA;
    var NOME_CONVERSA;
    telaConversa = $("#telaConversa");
    telaUsuarios = $("#telaUsuarios");
    telaConversa.hide();
    var onlineCPF = false;

    /*botões*/

    /*FUNÇÕES*/
    function verificaOnline(){
        var starCountRef = database.ref('/users/');
        starCountRef.on('value', function (snapshot) {
            snapshot.forEach(function (item) {
                if(item.val().status == "online"){
                    console.log("Cliente Online");
                    onlineCPF = true;
                }else{
                    console.log("Cliente offline");
                    onlineCPF = false;
                }
            });
        });
    }
    
    function scrollToBottom() {
        $('#telaMensagens').scrollTop($('#telaMensagens')[0].scrollHeight);
    }
    function escreveMensagem(cpf, mensagem) {
        console.log(cpf);
        var add = database.ref('mensagens/' + cpf + '/juniorNet/').push();
        add.set({
            mensagem: mensagem,
            tipo: 'recebimento'
        });
        var adds = database.ref('mensagens/juniorNet/' + cpf + '/').push();
        adds.set({
            mensagem: mensagem,
            tipo: 'recebimento'
        });
        if(!onlineCPF){
            //Adicionando uma notificação
            var not = database.ref('notificacoes/').push();
            not.set({
                mensagem: 'Nova mensagem de JRNET',
                tipo: 'chat',
                para: CPF_CONVERSA,
                title: 'Chat'
            });
        }
        scrollToBottom();
    }

    function adicionaCliente(item) {
        var cpf = item.val().juniorNet.cpf;
        telaUsuserios.append(
                '<a href="javascript:void(0)" id="item_usuario" cpf="' + cpf + '" nome="' + item.val().juniorNet.nome + '">' +
                '<li class="collection-item">' +
                '<span class="title">' + item.val().juniorNet.nome + '</span>' +
                '<p>' + item.val().juniorNet.email + '<br>' +
                '<i id="mensagem_' + cpf + '"></i>' +
                '</p>' +
                '</li>' +
                '</a>' +
                '<hr class="separate" />'
                );
    }
    function getClientes() {
        var starCountRef = database.ref('usuario_conversas');
        starCountRef.on('value', function (snapshot) {
            telaUsuserios.html('');
            snapshot.forEach(function (item) {
                adicionaCliente(item);
            });
        });
    }

    function adicionaMensagem(dados) {

        if (dados.tipo == "envio") {

            $("#mensagem").append('\
                <div id="contentMessage" class="messageL">' +
                    '<div class="body z-depth-2">' +
                    '<div class="header">' +
                    '<p>Cliente</p>' +
                    '</div>' +
                    '<p>' + dados.mensagem + '</p>' +
                    '</div>' +
                    '</div>');
        } else {
            $("#mensagem").append('\
                <div id="contentMessage" class="messageR">' +
                    '<div class="body z-depth-2">' +
                    '<div class="header">' +
                    '<p>Junior Net</p>' +
                    '</div>' +
                    '<p>' + dados.mensagem + '</p>' +
                    '</div>' +
                    '</div>');

        }
        scrollToBottom();
    }
    function getMensagens(cpf) {
        var starCountRef = database.ref('mensagens/' + cpf + '/juniorNet/');
        starCountRef.on('value', function (snapshot) {
            $("#mensagem").html('');
            snapshot.forEach(function (item) {
                adicionaMensagem(item.val());
                
            });
        });
        setTimeout(function(){
            scrollToBottom();
        },500);
    }

    getClientes();

    /*AÇÕES DE BOTÕES*/
    $("#colectionUsers").delegate("a[id^='item_usuario']", 'click', function () {
        var cpf = $(this).attr("cpf");
        var nome = $(this).attr("nome");
        /*Limpando a tela de mensagens*/
        $("#mensagem").html('');
        CPF_CONVERSA = cpf;
        NOME_CONVERSA = nome;
        $("#nomeCliente").html('');
        $("#nomeCliente").html(nome);

        //Buscando as mensagens da conversa
        getMensagens(cpf);
        telaConversa.fadeIn(200);
        telaUsuarios.hide();
        $("#campoMensagem").focus();
        verificaOnline();
    });
    $("#btnVoltar").on('click', function () {
        telaConversa.hide();
        telaUsuarios.fadeIn(200);
    });

    //Adicionando mensagem
    $("#btnSend").on('click', function () {
        var mensagem = $("#campoMensagem").val();
        if(mensagem != ""){
            escreveMensagem(CPF_CONVERSA, mensagem);
            $("#campoMensagem").val('');
        }
    });

    //
    $("#formInput").submit(function () {
        $("#btnSend").click();
        return false;
    });
});