$(document).ready(function(){ 
  var pageName = "view/adminMenu.php";
  $("#wrapper").load(pageName);
});

// need to use delegation based event handlers here, because later links do not exisst in the DOM yet
$(document).on('click', '.link', function(){
   pageName = "view/" + $(this).attr("name") + ".php";
  	$("#wrapper").load(pageName);
});


$(document).on('click', '.finishRound', function(){
	alert("FINISH HIM");
});