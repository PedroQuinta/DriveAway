$(document).ready(function(){

	$(document).on("click", ".collapsible-body p a" ,function(event) {
		//console.log($(this).attr('id'));
		$(this).closest('p').remove();
		//$(".badge").html((parseInt($(".badge").html) -1)); 
		console.log($(".badge").html());
		/*
		if(i<0){
			//$(".collapsible").remove();
			$("#alertas").hide();
		}
		*/
	});

	

	
	


	function refresh(){
		$.ajax({url: "carregar_notificacao.php" ,success: function(result){
			$(".collapsible-body").html(result);
			chechExisteNotifications();
		}});
	}  

	refresh();

	var timeout = setInterval(function() {			    
		refresh();
        console.log("atualizou");
    }, 10000);



});

function chechExisteNotifications(){
	if ( $('#collapsible-body').children().length > 0 ) {
    	$("#alertas").show();
	}
	else{
		$("#alertas").hide();
	}
}