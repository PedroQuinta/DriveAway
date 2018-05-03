$(document).ready(function(){
	 var id;
	 var operation;
    // initialize and set up facebook javascript sdk
    
    
    $(document).on("click", "#facebook_perfil", function(){
    	operation=1;
    	login(operation);
    	return false;
    });

    $(document).on("click", "#facebook_login", function(){
    	operation=2;
    	login(operation);
    	return false;
    });

	    window.fbAsyncInit = function() {
	      FB.init({
	        appId      : '170697620345126',
	        cookie     : true,
	        xfbml      : true,        
	        version    : 'v2.11'
	      });
	      
	      FB.AppEvents.logPageView();  

	        
	      };

	    (function(d, s, id){
	      var js, fjs = d.getElementsByTagName(s)[0];
	      if (d.getElementById(id)) {return;}
	      js = d.createElement(s); js.id = id;
	      js.src = "https://connect.facebook.net/en_US/sdk.js";
	      fjs.parentNode.insertBefore(js, fjs);
	    }(document, 'script', 'facebook-jssdk'));


	    function login(num){

	      FB.login(function(response){        
	        //console.log("entrou aqui");
	        if(response.status === "connected"){
	          document.getElementById("status").innerHTML="Okay you are connected";
	          info(num);
	        }else if(response.status==="not_authorized"){
	          document.getElementById("status").innerHTML="You are not connected.";
	        }else{
	          document.getElementById("status").innerHTML="You are not logged in facebook account.";
	        }
	      });
	    }

	    function info(num){
	       
	       FB.api('/me','GET',{fields: 'name, email, id'}, function(response){
	          
	            id = response.id;
	            console.log(id);
	            
	            $.ajax({
	              url: 'facebook.php?facebook_operation='+num+'&response_id='+id,
	              type: 'GET',                  
	              success:function(data){
	              	if(operation==2){
	              		location.href="index.php";
	              	}
	                
	              }
	            });
	       });
	    }
       
})