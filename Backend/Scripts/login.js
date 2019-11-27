$(document).ready(function(){
    var processos = '../Backend/Core/';
    
    $("#formLogin").submit(function(){
        var email = $("#campoEmail").val();
        var senha = $("#campoSenha").val();
        
        //enviando a requisição
        $.ajax({
            url: processos + 'login_admin.php',
            data:{email : email, senha : senha},
            type: "POST",
            dataType: "JSON",
            success: function (data) {
                if(data.erro){
                    M.toast({html: data.msg});
                }else{
                    //redirecionando
                    location.href="../../";
                }
            },
            error: function () {
                console.log('Houve um erro');
            }
        });
        
        //Não envia da forma convencional
        return false;
    });
    
});