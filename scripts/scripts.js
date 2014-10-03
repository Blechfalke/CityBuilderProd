var i_technology = null;
var i_kings = 0;
var i_priests = 0;
var i_craftsmen = 0;
var i_scribes = 0;
var i_soldiers = 0;
var i_peasants = 0;
var i_slaves = 0;
var i_total = 0;

var backupValue;

$(document).ready(function(){ 
  var pageName = "view/adminMenu.php";
  $("#wrapper").load(pageName);
  
  
//need to use delegation based event handlers here, because later links do not exist in the DOM yet
  $(document).on('click', '.link', function(){
     pageName = "view/" + $(this).attr("name") + ".php";
    	$("#wrapper").load(pageName);
  });

  $(document).on('click', '.finishRound', function(){
  	readInputs();
  	
  	$("#wrapper").load('view/CityManagement.php', {	kings: i_kings, priests: i_priests, craftsmen: i_craftsmen, 
  													scribes: i_scribes, soldiers: i_soldiers, peasants: i_peasants,
  													slaves: i_slaves, technology: i_technology});
  });

  $(document).on('change', '.editor', function() {
  	readInputs();
  	var available = i_total - i_kings - i_priests - i_craftsmen - i_scribes - i_soldiers - i_peasants - i_slaves;
  	
  	if (available >= 0) {
  		$('#AvailablePopulation').val(available);		
  	} else {
  		alert('You can not assign any more people');
  		$(this).val(backupValue);
  	}
  	
  	updatePyramid(i_slaves,i_peasants,i_soldiers,i_scribes,i_craftsmen,i_priests, i_kings);
  	
  	
  });

  $(document).on('focus', '.editor', function(){
  	backupValue = $(this).val();
  });

  $(document).on('keypress', '.editor', function(e){
  	//if the letter is not digit then don't type anything
      if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) 
      	return false;
  });
  
  $(document).on('click', '.technology.clickable', function(){
	  $('.technology.clickable').css('border','none');
	  $(this).css('border','2px solid black'); 
	  i_technology = $(this).attr('id');
  });
  
});

function updateTechnology(){
	$('.developed').each(function(){
 		$(this).prev().css('visibility', 'visible');
	});    
}
function readInputs(){
	i_total = $('#TotalPopulation').val();
	i_kings = $('#Kings').val();
	i_priests = $('#Priests').val();
	i_craftsmen = $('#Craftsmen').val();
	i_scribes = $('#Scribes').val();
	i_soldiers = $('#Soldiers').val();
	i_peasants = $('#Peasants').val();
	i_slaves = $('#Slaves').val();
}