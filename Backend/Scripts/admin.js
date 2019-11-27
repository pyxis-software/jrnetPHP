document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);

    var modal = document.querySelectorAll('.modal');
    optionModal = {
        dismissible: false
    };
    var instancesModal = M.Modal.init(modal, optionModal);

    var tabs = document.querySelectorAll('.tabs');
    var instancesTabs = M.Tabs.init(tabs);

    //select
    var elemSelect = document.querySelectorAll('select');
    var instancesSelect = M.FormSelect.init(elemSelect);

    //picker
    var elemsPicker = document.querySelectorAll('.datepicker');
    var instancesPicker = M.Datepicker.init(elemsPicker, {
        format: 'yyyy-mm-dd'
    });
});
$(document).ready(function () {
    var processos = '../../Backend/Core/';
    var idPlano = 0;
    var idMural = 0;
    var database = firebase.database();
    
    $("#infoErro").hide();
    /*NOTIFICAÇÕES*/
    var notifica = false;
    if (window.Notification && Notification.permission !== "denied") {
        notifica = true;
    }



    /*Adicionar plano*/
    $("#formAddPlano").submit(function () {
        //$("#btnAddPlano").click();
    });
    $("#btnAddPlano").on('click', function () {
        //recebendo os dados
        /*
         var titulo = $("#tituloPlano").val();
         var descricao = $("#descPlano").val();
         var valor = $("#valorPlano").val();
         if(descricao == "" || titulo == "" || valor == ""){
         M.toast({html: 'Dados em Branco!'});
         }else{
         //enviando os dados para o banco
         $.ajax({
         url: processos + 'addPlano.php',
         data: {titulo : titulo, desc : descricao, valor: valor},
         type: 'POST',
         dataType: 'JSON',
         statusCode: {
         302: function(){
         M.toast({html: 'Muitos Redirecionamentos Internos!'});
         }
         },
         success: function (data) {
         if(data.erro){
         M.toast({html: data.msg});
         }else{
         location.reload();
         }
         },
         error: function () {
         M.toast({html: 'Erro interno do sistema!'});
         }
         });
         }
         */
    });
    /*Excluindo planos*/
    $("a[id^='btnExcluPlano']").on('click', function () {
        var id = $(this).attr("idplano");
        idPlano = id;
        var titulo = $(this).attr('titulo');
        $("#textoPlanoModal").html('');
        $("#textoPlanoModal").html(titulo);
        $("#infoErro").hide();
        $("#infoErro").html('');
    });
    $("#btnConfirm").on('click', function () {
        $("#infoErro").html('');
        $.ajax({
            url: processos + 'excluirPlano.php',
            data: {id: idPlano},
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.erro) {
                    //adicionando as informações no modal
                    $("#infoErro").append(data.msg);
                    //percorrendo os usuários
                    $.each(data.usuarios, function (i, user) {
                        $("#infoErro").append(user + "<br />");
                    });
                    $("#infoErro").append('<br /><br /><a href="../../clientes" class="waves-effect waves-light btn red">Ver Clientes</a>');
                    $("#infoErro").show();
                } else {
                    location.href = '../../planos';
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema!'});
            }
        });
    });
    /*Editar Plano*/
    $("a[id^='btnEditPlano'").on('click', function () {
        var id = $(this).attr('idplano');
        idPlano = id;
        $("#campoId").val(idPlano);
        $.ajax({
            url: processos + 'buscaPlano.php',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.erro) {
                    M.toast({html: data.msg});
                } else {
                    console.log(data.dados);
                    $("#nomePlanoEdit").html('');
                    $("#tituloPlanoEdit").html('');
                    $("#descPlanoEdit").html('');
                    $("#valorPlanoEdit").html('');
                    //alterando os valores
                    $("#nomePlanoEdit").html(data.dados.titulo);
                    $("#tituloPlanoEdit").val(data.dados.titulo);
                    $("#descPlanoEdit").html(data.dados.desc);
                    $("#valorPlanoEdit").val(data.dados.valor);
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema!'});
            }
        });
    });
    $("#formEditPlano").submit(function () {

    });
    $("#btnSalva").on('click', function () {
        /*
         //recebendo os dados
         var titulo = $("#tituloPlanoEdit").val();
         var descricao = $("#descPlanoEdit").val();
         var valor = $("#valorPlanoEdit").val();
         if(descricao == "" || titulo == "" || valor == ""){
         M.toast({html: 'Dados em Branco!'});
         }else{
         //enviando os dados para o banco
         $.ajax({
         url: processos + 'editaPlano.php',
         data: {titulo : titulo, desc : descricao, valor: valor, id: idPlano},
         type: 'POST',
         dataType: 'JSON',
         success: function (data) {
         if(data.erro){
         M.toast({html: data.msg});
         }else{
         location.reload();
         }
         },
         error: function () {
         M.toast({html: 'Erro interno do sistema!'});
         }
         });
         }
         */
    });
    /*ADICIONAR MURAL*/
    $("#formAddMural").submit(function () {
        $("#btnAddMural").click();
        return false;
    });
    $("#btnAddMural").on('click', function () {
        var titulo = $("#tituloMural").val();
        var desc = $("#descMural").val();
        if (titulo == "" || desc == "") {
            M.toast({html: 'Dados em Branco!'});
        } else {
            //enviando os dados para o banco de dados
            $.ajax({
                url: processos + 'adicionaMural.php',
                data: {titulo: titulo, desc: desc},
                type: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if (data.erro) {
                        M.toast({html: data.msg});
                    } else {
                        
                        $.each(data.clientes, function(i, cpf){
                            var not = database.ref('notificacoes/').push();
                            not.set({
                                title: titulo,
                                mensagem: desc,
                                tipo: 'informacao',
                                para: cpf,
                                clientes: data.clientes
                            });
                        });
                        
                        location.reload();
                    }
                },
                error: function () {
                    M.toast({html: 'Erro interno do sistema!'});
                }
            });
        }
    });
    /*EDITAR MURAL*/
    $("a[id^='btnEditMural']").on('click', function () {
        var id = $(this).attr("idmural");
        idMural = id;
        //buscando as informações do mural
        $.ajax({
            url: processos + 'buscaMural.php',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.erro) {

                } else {
                    //limpando a tela
                    $("#nomeEditMural").html('');
                    $("#tituloMuralEdit").val('');
                    $("#descMuralEdit").html('');
                    //alterando os valores
                    $("#nomeEditMural").html(data.dados.titulo);
                    $("#tituloMuralEdit").val(data.dados.titulo);
                    $("#descMuralEdit").html(data.dados.desc);
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema!'});
            }
        });
    });
    $("#btnSalvaMural").on('click', function () {
        //recebendo os dados
        var titulo = $("#tituloMuralEdit").val();
        var desc = $("#descMuralEdit").val();
        //verifica
        if (titulo == "" || desc == "") {
            M.toast({html: 'Dados em Branco!'});
        } else {
            $.ajax({
                url: processos + 'editaMural.php',
                data: {id: idMural, titulo: titulo, desc: desc},
                type: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if (data.erro) {
                        M.toast({html: data.msg});
                    } else {
                        location.reload();
                    }
                },
                error: function () {
                    M.toast({html: 'Erro interno do sistema!'});
                }
            });
        }
    });
    /*EXCLUIR MURAL*/
    $("a[id^='btnExcluMural']").on('click', function () {
        var id = $(this).attr("idmural");
        var titulo = $(this).attr("titulo");
        idMural = id;
        $("#textoInfoMural").html('');
        $("#textoInfoMural").html(titulo);
    });
    $("#btnConfirmMural").on('click', function () {
        $.ajax({
            url: processos + 'excluiMural.php',
            data: {id: idMural},
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.erro) {
                    M.toast({html: data.msg});
                } else {
                    location.reload();
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema!'});
            }
        });
    });
    /*GERAR BOLETO*/
    $("#progressFaturamento").hide();
    $("#btnGeraFatura").on('click', function () {
        $(this).hide();
        var valor = $("#valorBoleto").val();
        var diaVencimento = $("#diaVencimento").val();
        var dias = $("#diasVencimento").val();
        var nomeUser = $("#nomeUser").val();
        var cpfUser = $("#cpfUser").val();
        var emailUser = $("#emailUser").val();
        var endUser = $("#endlUser").val();
        var cidadeUser = $("#cidadeUser").val();
        var id = $("#idUser").val();
        var id_payment;
        var link;
        var bar_code;
        var status;
        var descricao;
        if (diaVencimento != "") {
            $("#progressFaturamento").fadeIn(200);
            $("#telaDadosForm").hide();
            //
            $.ajax({
                url: processos + 'payment.php',
                data: {id: id, valor: valor, dia_venc: diaVencimento, dias: dias, nome: nomeUser, cpf: cpfUser, email: emailUser, endereco: endUser, cidade: cidadeUser},
                type: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if (data.captured == true) {
                        console.log(data.transaction_details.external_resource_url);
                        link = data.transaction_details.external_resource_url;
                        status = data.status;
                        id_payment = data.id;
                        bar_code = data.barcode.content;
                        descricao = data.description;
                        $.ajax({
                            url: processos + 'salvaFatura.php',
                            data: {id: id, valor: valor, dia_venc: diaVencimento, dias: dias, nome: nomeUser, cpf: cpfUser, email: emailUser, endereco: endUser, cidade: cidadeUser, link: link, id_payment: id_payment, status: status, barcode: bar_code},
                            type: 'POST',
                            dataType: 'JSON',
                            success: function (data) {
                                console.log(data);
                                if (data.erro) {
                                    M.toast({html: data.msg});
                                } else {
                                    var not = database.ref('notificacoes/').push();
                                    not.set({
                                        title: 'Fatura',
                                        mensagem: descricao,
                                        tipo: 'informacao',
                                        para: data.cpf,
                                        clientes: ''
                                    });
                                    location.reload();
                                }
                            },
                            error: function () {
                                M.toast({html: 'Encontramos um problema!Tente novamente.'});
                            }
                        });
                    } else {
                        M.toast({html: 'O boleto não foi gerado!'});
                    }
                },
                error: function () {
                    alert("Erro");
                }
            });
            $("#telaDadosForm").fadeIn(200);
        } else {
            M.toast({html: 'Informe a data de vencimento.'});
        }
        $(this).fadeIn(200);
    });
    /*ATIVA CLIENTE*/
    $("#btnAtiva").on('click', function () {
        var id = $(this).attr("lang");
        $.ajax({
            url: processos + 'AtivaCliente.php',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.erro) {
                    M.toast({html: data.msg});
                } else {
                    location.reload();
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema.'});
            }
        });
    });
    /*REMOVER CLIENTE*/
    $("#btnRemove").on('click', function () {
        var id = $(this).attr("lang");
        $.ajax({
            url: processos + 'RemoveCliente.php',
            data: {id: id},
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.erro) {
                    M.toast({html: data.msg});
                } else {
                    location.href = '../../clientes';
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema.'});
            }
        });
    });

    /*Marcar como pago*/
    $("a[id^='btnMPago']").on('click', function () {
        var id = $(this).attr("lang");
        $.ajax({
            url: processos + 'MarcaPago.php',
            data: {id: id},
            type: 'POST',
            success: function (data) {
                if(data.erro){
                    M.toast({html: data.msg});
                }else{
                    location.reload();
                }
                
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema.'});
            }
        });
    });


    //Salvar configurações
    $("#btnSalvaConf").on('click', function () {
        var token = $("#token").val();
        var dias = $("#dias_venc").val();
        var desc = $("#descri").val();
        var email = $("#email").val();
        var end = $("#ende").val();
        var tel = $("#telefone").val();
        $.ajax({
            url: processos + 'salvaConfig.php',
            data: {token: token, dias: dias, desc: desc, email: email, end: end, tel: tel},
            dataType: 'JSON',
            type: 'POST',
            success: function (data) {
                if (data.erro) {
                    M.toast({html: data.msg});
                } else {
                    location.reload();
                }
            },
            error: function () {
                M.toast({html: 'Erro interno do sistema.'});
            }
        });
    });
    
    
    /*ALTERAR PLANOS*/
    $("#alterarPlano").on('click', function(){
        var idCliente = $("#idCliente").val();
        var idPlano = $("#selectPlano").val();
        var cpf = $("#cpfCliente").attr("lang");
        if(idPlano != 0){
            $.ajax({
                url: processos + 'alteraPlano.php',
                data:{cliente: idCliente, plano: idPlano},
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    console.log(data);
                    if (data.erro) {
                        M.toast({html: data.msg});
                    } else {
                        var not = database.ref('notificacoes/').push();
                        not.set({
                            title: 'Alteração de Plano',
                            mensagem: 'Seu plano foi alterado para ' + data.plano,
                            tipo: 'informacao',
                            para: cpf,
                            clientes: ''
                        });
                        location.reload();
                    }
                },
                error: function () {
                    M.toast({html: 'Erro interno do sistema.'});
                }
            });
        }else{
            M.toast({html: 'Por favor, selecione um plano'});
        }
    });
    
    
    /*ALTERAR PLANOS*/
});