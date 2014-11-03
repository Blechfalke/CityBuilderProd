<?php
require_once '../config.php';

if (isset ( $_GET ['msg'] ))
	if ($_GET ['msg'] == 'blocked') {
		$msg = $_GET ['msg'];
		switch ($_GET ['zone']) {
			case 'zone_1' :
				$textStartPopup = "<p>" . gettext ( 'You have chosen to found your city in the middle of fertile lands, irrigated by the river. The recolts will be aboundants.' ) . "</p>";
				break;
			case 'zone_2' :
				$textStartPopup = "<p>" . gettext ( 'You have chosen to found your city in the desert. We have found a few oasises that should provide a bit of food to survive' ) . "</p>";
				break;
			case 'zone_3' :
				$textStartPopup = "<p>" . gettext ( 'You have chosen to found your city in the mountains.  A few water sources will help us gather the bare minimal we need.' ) . "</p>";
				break;
			default :
				$textStartPopup = "<p>" . gettext ( 'You have chosen to found your city in the middle of fertile lands, irrigated by the river. The recolts will be aboundants.' ) . "</p>";
				break;
		}
		echo "<script>project.alert('$textStartPopup');</script>";
	}
?>

<div id="header"><?php echo gettext('Placement of the city');?></div>
<div id="leftContentMap">
	<img src="css/images/mapPap.png" border="0" width="704" height="587"
		orgWidth="704" orgHeight="587" usemap="#imagemap" alt="" />
	<div class="cityCircle hover" id="zone_1"
		onclick="handlePlacement($(this))" style="top: 230px; left: 190px;"></div>
	<div class="cityCircle hover" id="zone_2"
		onclick="handlePlacement($(this))" style="top: 550px; left: 200px;"></div>
	<div class="cityCircle hover" id="zone_2"
		onclick="handlePlacement($(this))" style="top: 415px; left: 420px;"></div>
	<div class="cityCircle hover" id="zone_3"
		onclick="handlePlacement($(this))" style="top: 230px; left: 490px;"></div>
	<map name="imagemap">
		<area shape="rect" coords="702,585,704,587" alt="Image Map"
			style="outline: none;" title="Image Map"
			href="http://www.image-maps.com/index.php?aff=mapped_users_34341" />
		<area class="hover" id="zoneThree" shape="poly"
			coords="432,219,397,243,660,481,657,353,586,298,514,254,436,193,466,201,477,219,577,253,599,240,598,217,599,196,597,175,594,156,610,149,611,168,619,199,614,234,657,227,658,28,608,30,606,67,512,105,456,135"
			style="outline: none;" target="_self" />
		<area class="hover" id="zoneOne" shape="poly"
			coords="100,132,127,113,145,116,154,104,193,94,234,88,262,94,272,83,341,93,340,142,156,173"
			style="outline: none;" target="_self" />
		<area class="hover" id="zoneTwo" shape="poly"
			coords="34,148,44,558,659,556,660,462,381,241,416,216,391,186,373,170,379,161,398,164,416,181,437,196,461,135,505,101,603,68,586,40,595,27,545,21,518,27,500,61,417,88,397,90,343,95,332,138,161,169,106,130,67,147"
			style="outline: none;" target="_self" />
	</map>
</div>
<div id="rightContent">
	<div id='rightUp'>
		<img id='flavourImage' src='css/images/blank.png'
			style='width: 180px; height: 150px;' />
		<p id='flavourText'></p>
	</div>

	<div id="rightBottom">
		<input type='button' value='<?php echo gettext('Exit game');?>'
			name='startMenu' class='pageButtons link' style="margin-top: 90px;" />
	</div>
</div>
<div style="clear: both;"></div>
