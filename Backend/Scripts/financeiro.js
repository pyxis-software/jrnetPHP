$(document).ready(function () {
    //buscaMesesGrafico.php
    var processos = '../../Backend/Core/';

    function removeData(chart) {
        chart.data.labels.pop();
        chart.data.datasets.forEach((dataset) => {
            dataset.data.pop();
        });
        chart.update();
    }
    function addData(chart, data) {
        chart.data = data;
        chart.update();
    }

    var ctx = document.getElementById('chartMeses').getContext('2d');
    var chartMeses = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',
        fill: false,
        options: {
            scales: {
                xAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Meses'
                        }
                    }],
                yAxes: [{
                        display: true,
                        scaleLabel: {
                            display: true,
                            labelString: 'Valor Recebido'
                        }
                    }]
            },
            responsive: true
        }
    });

    var ctxInfo = document.getElementById('chartInfo').getContext('2d');
    var chartInfo = new Chart(ctxInfo, {
        // The type of chart we want to create
        type: 'pie',
        fill: false,
        options: {
            responsive: true
        }
    });


    //Buscando os dados para o gráfico
    $.ajax({
        url: processos + 'buscaMesesGrafico.php',
        data: {},
        type: "POST",
        dataType: "JSON",
        success: function (data) {
            addData(chartMeses, data.dados);
        },
        error: function () {
            M.toast({html: 'Erro interno do sistema!'});
        }
    });

    $("#containerInfo").hide();
    var clientes = [];
    $('#selectMes').change(function () {
        var mes = $(this).val();
        if ($(this).val() != 0) {
            $.ajax({
                url: processos + 'dadosMes.php',
                data: {mes: mes},
                type: "POST",
                dataType: "JSON",
                success: function (data) {
                    if (!data.erro) {
                        //Adicionando os dados na tela
                        $("#valorRecebido").html('');
                        $("#valorRecebido").html('R$ ' + data.dados.faturamentoRecebido);
                        
                        $("#valorPendente").html('');
                        $("#valorPendente").html('R$ ' + data.dados.faturamentoPendente);
                        
                        
                        removeData(chartInfo);
                        var dat = {
                            labels: ['Recebido', 'Não Recebido'],
                            datasets: [{
                                    label: 'R$ #',
                                    data: [data.dados.faturamentoRecebido, data.dados.faturamentoPendente],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 0.2)',
                                        'rgba(54, 162, 235, 0.2)',
                                    ],
                                    borderColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                    ],
                                    borderWidth: 1
                                }]
                        };
                        addData(chartInfo, dat);
                        
                        //Adicionando os clientes na tela
                        clientes = data.dados.clientes;
                        $("#telaClientesMes").html('');
                        $.each(clientes, function(i, cliente){
                            //regra de negócio
                            
                            //Existe fatura no mês e foi paga
                            if(cliente.existe && cliente.status){
                                $("#telaClientesMes").append('<div class="card-panel teal lighten-2">'+
                                    '<div class="row">'+
                                        '<div class="col s12 m6">'+
                                            '<b>'+cliente.nome + '</b>'+
                                        '</div>'+
                                        '<div class="col s12 m2">'+
                                            '<b>R$ <i style="font-size: 23px;">' + cliente.valor +'</i></b>'+
                                        '</div>'+
                                        '<div class="col s12 m4">'+
                                            'Lançada em <b>'+ cliente.lancamento+' </b>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                            
                            //Existe mas não foi paga
                            }else if(cliente.existe && !cliente.status){
                                $("#telaClientesMes").append('<div class="card-panel red darken-1">'+
                                    '<div class="row">'+
                                        '<div class="col s12 m6">'+
                                            '<b>'+cliente.nome + '</b>'+
                                        '</div>'+
                                        '<div class="col s12 m2">'+
                                            'Nome'+
                                        '</div>'+
                                        '<div class="col s12 m4">'+
                                            'Nome'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                            }else{
                                $("#telaClientesMes").append('<div class="card-panel">'+
                                    '<div class="row">'+
                                        '<div class="col s12 m6">'+
                                            '<b>'+cliente.nome + '</b>'+
                                        '</div>'+
                                        '<div class="col s12 m4">'+
                                            '<b>Sem fatura no mês</b>'+
                                        '</div>'+
                                        '<div class="col s12 m2">'+
                                            '<a href="../../clientes/'+cliente.id+'" class="waves-effect waves-light btn">Ver Perfil</a>'+
                                        '</div>'+
                                        
                                    '</div>'+
                                '</div>');
                            }
                            
                            
                        });


                        $("#containerInfo").fadeIn();
                    } else {
                        M.toast({html: data.msg});
                    }
                },
                error: function () {
                    M.toast({html: 'Erro interno do sistema!'});
                }
            });
        }
    })
});