<?php
?>

<div id="header"><?php echo gettext('The Game is loading<br />Please Wait...');?></div>
<div id='progressbar'></div>


<script type="text/javascript">

	var loadedImages = 0;
	
    var imageArray = new Array(		'css/images/background.jpg',	
	    	    					'css/images/palace.jpg',
	    	    					'css/images/arrow.png',	
	    	    					'css/images/arrowDown.png',
	    	    					'css/images/blank.png',
	    	    					'css/images/checkmark.png',
	    	    					'css/images/granary.png',
	    	    					'css/images/map.png',
	    	    					'css/images/mapPap.png',
	    	    					'css/images/pap.png',
	    	    					'css/images/papVert.png',
	    	    					'css/images/papy.png',
	    	    					'css/images/pottery.png',
	    	    					'css/images/writing.png',
	    	    					'css/images/flavourImages/caravan_desc.png',
	    	    					'css/images/flavourImages/craftsmen_desc.png',
	    	    					'css/images/flavourImages/desert_desc.png',
	    	    					'css/images/flavourImages/fertile_desc.png',
	    	    					'css/images/flavourImages/granary_desc.png',
	    	    					'css/images/flavourImages/mountains_desc.png',
	    	    					'css/images/flavourImages/peasants_desc.png',
	    	    					'css/images/flavourImages/pharaon_desc.png',
	    	    					'css/images/flavourImages/pottery_desc.png',
	    	    					'css/images/flavourImages/priest_desc.png',
	    	    					'css/images/flavourImages/scribes_desc.png',
	    	    					'css/images/flavourImages/slave_desc.png',
	    	    					'css/images/flavourImages/soldier_desc.png',
	    	    					'css/images/flavourImages/writing_desc.png',
	    	    					'css/images/flavourImages/building_desc.png',
	    	    					'css/images/flavourImages/citizen_desc.png',
	    	    					'css/images/flavourImages/hapiness_desc.png',
	    	    					'css/images/flavourImages/tech_desc.png',
	    	    					'css/images/flavourImages/total_desc.png',
	    	    					'css/images/flavourImages/wealth_desc.png',
	    	    					'css/images/dialogs/caravan.png',
	    	    					'css/images/dialogs/endbad.png',
	    	    					'css/images/dialogs/endgood.png',
	    	    					'css/images/dialogs/endintermediate.png',
	    	    					'css/images/dialogs/endofturn.png',
	    	    					'css/images/dialogs/exitduringgame.png',
	    	    					'css/images/dialogs/exitvalid.png',
	    	    					'css/images/dialogs/granary.png',
	    	    					'css/images/dialogs/invasion.png',
	    	    					'css/images/dialogs/monument.png',
	    	    					'css/images/dialogs/palace.png',
	    	    					'css/images/dialogs/placedesert.png',
	    	    					'css/images/dialogs/placefertile.png',
	    	    					'css/images/dialogs/placement.png',
	    	    					'css/images/dialogs/placemountain.png',
	    	    					'css/images/dialogs/pottery.png',
	    	    					'css/images/dialogs/ramparts.png',
	    	    					'css/images/dialogs/temple.png',
	    	    					'css/images/dialogs/unhappiness.png',
	    	    					'css/images/dialogs/writing.png');

    preloadImages();
    
    function preloadImages(e) {
    	$( '#progressbar' ).progressbar({
		    value: 0,
		    max: imageArray.length
	    });
	    
	    for (var i = 0; i < imageArray.length; i++) {
	        var tempImage = new Image();
	         
	        tempImage.addEventListener('load', trackProgress, true);
	        tempImage.src = imageArray[i];
	    }
	}
	
	function trackProgress() {
	    loadedImages++;
	    
	    $( '#progressbar' ).progressbar( 'option', 'value', loadedImages );	    
	    if (loadedImages == imageArray.length) {
	        imagesLoaded();
	    }
	}

	function imagesLoaded() {
// 		var pageName = "view/login.php";
// 		$("#wrapper").load(pageName);
		$.ajax({
		    type: 'GET',
		    url: 'view/login.php',
		    dataType: 'html',
		    async: false,
		    timeout: 30000,
		    success: function(h){ 
			    $("#wrapper").html(h) 
			},
			error: function(h){
				alert('an Error occured')
			}
		});
		
	}
</script>