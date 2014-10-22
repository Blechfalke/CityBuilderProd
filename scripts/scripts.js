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
$(document).ready(function() {
	// This will be the starting page of the Application
	var pageName = "view/login.php";
	$("#wrapper").load(pageName);

	// need to use delegation based event handlers here, because later links do
	// not exist in the DOM yet
	$(document).on('click', '.link', function() {
		pageName = "view/" + $(this).attr("name") + ".php";
		$("#wrapper").load(pageName);
	});


		$(document).on('click', '#endTheTurn', function() {
		project.confirm('Unhappiness POPUP', 'End the turn', 'Cancel');
		
		});
		
	$(document).on('click', '.login', function() {
		pageName = "controller/class.loginController.php";
		$("#wrapper").load(pageName, {
			username : $('#username').val(),
			password : $('#password').val(),
			locale : $('.locale').val()
		});
	});

	$(document).on('click', '.logout', function() {
		pageName = "controller/class.LogoutController.php";
		$("#wrapper").load(pageName);
	});
	
	$(document).on('click', '.gameMode', function() {
		pageName = "controller/class.gameModeController.php";
		$("#wrapper").load(pageName, {
			newMode : $(this).attr("id")
		});
	});

	$(document).on('click', '.cityCircle', function() {
		pageName = "view/CityManagement.php";
		$("#wrapper").load(pageName, {
			zone : $(this).attr("id")
		});
	});

	$(document).on('change', '.editor', function() {
		updateAvailablePopulation();
	});

	$(document).on('focus', '.editor', function() {
		backupValue = $(this).val();
		updateFlavourText($(this));
	});

	$(document).on('keypress', '.editor', function(e) {
		// if the letter is not digit then don't type anything
		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57))
			return false;
	});

	$(document).on('click', '.technology.clickable', function() {
		$('.technology.clickable').css('border', 'none');
		if (i_technology == $(this).attr('id')) {
			$(this).css('border', 'none');
			i_technology = null;
		} else {
			$(this).css('border', '2px solid black');
			i_technology = $(this).attr('id');
		}

	});

	$(document).on('mouseover', '.hover', function() {
		updateFlavourText($(this));
	});
});

function updateTechnology() {
	$('.developed').each(function() {
		$(this).prev().css('visibility', 'visible');
	});
}

function updateAvailablePopulation(caller) {
	readInputs();
	var available = i_total - i_kings - i_priests - i_craftsmen - i_scribes
			- i_soldiers - i_peasants - i_slaves;
	//var id = '#' + idOfModifiedInputField;
	if (available >= 0) {
		$('#AvailablePopulation').val(available);
	} else {
		// project.alert('You can not assign any more people');
		var maximum = available + Number(caller.val());
		caller.val(maximum);
		$('#AvailablePopulation').val(0);
	}

	updatePyramid(i_slaves, i_peasants, i_soldiers, i_scribes, i_craftsmen,
			i_priests, i_kings);
}

function readInputs() {
	i_total = $('#TotalPopulation').val();
	i_kings = $('#Kings').val();
	i_priests = $('#Priests').val();
	i_craftsmen = $('#Craftsmen').val();
	i_scribes = $('#Scribes').val();
	i_soldiers = $('#Soldiers').val();
	i_peasants = $('#Peasants').val();
	i_slaves = $('#Slaves').val();
}

function updateFlavourText(caller) {
	switch (caller.attr('id')) {
	case 'lbl_Kings':
	case 'Kings':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/pharaon_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_king;
		break;
	case 'lbl_Priests':
	case 'Priests':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/priest_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_priest;
		break;
	case 'lbl_Craftsmen':
	case 'Craftsmen':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/craftsmen_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_craftsmen;
		break;
	case 'lbl_Scribes':
	case 'Scribes':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/scribes_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_scribes;
		break;
	case 'lbl_Soldiers':
	case 'Soldiers':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/soldier_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_soldiers;
		break;
	case 'lbl_Peasants':
	case 'Peasants':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/peasants_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_peasants;
		break;
	case 'lbl_Slaves':
	case 'Slaves':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/slave_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_slaves;
		break;
	case 'granary':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/granary_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_granary;
		break;
	case 'writing':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/writing_desc.png');
		document.getElementById('flavourText').innerHTML = word_flavour_writing;
		break;
	case 'pottery':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/pottery_desc.png');
		document.getElementById('flavourText').innerHTML = world_flavour_pottery;
		break;
	case 'lbl_Caravans':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/caravan_desc.png');
		document.getElementById('flavourText').innerHTML = world_flavour_lbl_Caravans;
		break;
	case 'zone_1':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/fertile_desc.png');
		document.getElementById('flavourText').innerHTML = world_flavour_zone1;
		break;
	case 'zone_2':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/desert_desc.png');
		document.getElementById('flavourText').innerHTML = world_flavour_zone2;
		break;
	case 'zone_3':
		$('#flavourImage').attr('src',
				'css/images/flavourImages/mountains_desc.png');
		document.getElementById('flavourText').innerHTML = world_flavour_zone3;
		break;
	}

}

// window.onbeforeunload = function (e) {
// e = e || window.event;
//
// // For IE and Firefox prior to version 4
// if (e) {
// e.returnValue = 'Sure?';
// }
//
// // For Safari
// return 'Sure?';
// };

