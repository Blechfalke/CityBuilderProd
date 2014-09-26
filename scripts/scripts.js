var category = null;

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
	var i_kings = $('#Kings').val();
	var i_priests = $('#Priests').val();
	var i_craftsmen = $('#Craftsmen').val();
	var i_scribes = $('#Scribes').val();
	var i_soldiers = $('#Soldiers').val();
	var i_peasants = $('#Peasants').val();
	var i_slaves = $('#Slaves').val();
	
	$("#wrapper").load('view/CityManagement.php', {	kings: i_kings, priests: i_priests, craftsmen: i_craftsmen, 
													scribes: i_scribes, soldiers: i_soldiers, peasants: i_peasants,
													slaves: i_slaves});
});