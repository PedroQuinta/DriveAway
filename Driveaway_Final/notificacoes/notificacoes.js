$(document).ready(function(){

	$(document).on("click", "li.list-group-item a" ,function(event) {
		//console.log($(this).attr('id'));
		$(this).closest('.list-group-item').remove();
		//$(".badge").html((parseInt($(".badge").html) -1)); 
		
		
		
		
	});

	

	
	


	function refresh_not(){
		$.ajax({
			url: "notificacoes/carregar_notificacao.php",
			type: "get",
			dataType: 'json',
			success: function(result){
				//console.log(result);
				var noti = result.notificacoes; 
				var html = ""; 
				//$(".list-group").html(result);
				 for(var x=0;x<noti.length;x++){
				 	html+="<li class='list-group-item'><a href='#' id='"+noti[x].alerta_idalerta+"' data-url='notificacoes/alterar_estado_notificacao.php?id_estado="+noti[x].alerta_idalerta+"&target=" +noti[x].destino+ "' >" +noti[x].descricao+"</a></li>";
				 }

				 $(".list-group").html(html);
				chechExisteNotifications();
			}
		});
	}  

	refresh_not();

	var timeout = setInterval(function() {			    
		refresh_not();
       // console.log("atualizou");
    }, 10000);



});

function chechExisteNotifications(){
	if ( $('.list-group').children().length > 0 ) {
    	$("#alertas").show();
	}
	else{
		$("#alertas").hide();
	}
}
