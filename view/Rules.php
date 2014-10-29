<?php require_once '../config.php';
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>

    <div id="wrapper">
        <div id="header"><?php echo gettext('Rules');?></div>
       <div id='ruleContant'>
		<div class="ruleHeader">But du jeu</div>
		<div class="ruleMessage">Le but du jeu Bâtisseur de cité est de faire prospérer une petite société dans la 
		vallée du Nil pendant l’Égypte antique. Vous incarnez le dirigeant de cette communauté et vous allez prendre 
		des décisions qui vont influencer le développement et l’avenir de votre peuple. </div>
		
		<div class="ruleHeader">Le choix de l’emplacement de départ</div>
		<div class="ruleMessage">Après avoir vécu en nomade plusieurs siècles, vous trouvez une terre cultivable et 
		décidez de vous y installer. Certaines régions renferment cependant plus de terres exploitables que d’autres. 
		La proximité de l’eau augmente par exemple les récoltes et permet de développer plus rapidement la population.</div>
		
		<div class="ruleHeader">La gestion de la cité</div>
		<div class="ruleMessage">Fonder une cité dans un emplacement approprié n’était que la première étape. Maintenant 
		il vous faut donner des tâches à vos habitants pour assurer le bon fonctionnement de votre cité. À vous de répartir 
		judicieusement votre population dans les différents rôles nécessaires à votre société. </div>
		<ul>
		<li>
		<div class="ruleHeader">Le pouvoir royal</div>
		<div class="ruleMessage">
		Pour l’instant votre pouvoir est absolu car vous êtes seul aux commandes de votre cité. Mais un second dirigeant pourrait
		 provoquer de l’instabilité dans la société.
		</div>
		</li>
		<li>
		<div class="ruleHeader">La religion</div>
		<div class="ruleMessage">Dans la pensée égyptienne, les dieux façonnèrent la Terre et établirent un ordre harmonieux permettant 
		au miracle de la vie de s'accomplir jour après jour. C'est au seul pharaon, descendant des dieux, que revient la tâche d'assurer 
		la pérennité de cette harmonie et de combattre les forces du mal L'entretien de l'harmonie divine exigeant de nombreux cultes.
		 Une poignée de prêtres viennent en aide au pharaon dans cette quête.</div>
		</li>
		<li>
		<div class="ruleHeader">L’administration</div>
		<div class="ruleMessage">Pour pouvoir répartir efficacement les ressources produites, vous avez besoin d’un petit nombre de scribes 
		qui pour vous sillonnent la région et comptabilisent les récoltes. Sans scribes, une grande partie de la nourriture pourrait être mal 
		répartie dans votre cité et finalement perdue.</div>
		</li>
		<li>
		<div class="ruleHeader">La guerre</div>
		<div class="ruleMessage">Pour protéger vos habitants et vos récoltes, vous devez entretenir une bonne garnison de guerriers qui repousseront
		 toutes incursions étrangères. Un nombre insuffisant de défenseur et les pillards s’empareront d’une partie de vos habitants pour en faire des esclaves. </div>
		</li>
		<li>
		<div class="ruleHeader">La nourriture</div>
		<div class="ruleMessage">Votre peuple a faim, nourrissez-le et il continuera de vous soutenir en tant que pharaon. Une récolte insuffisante, au contraire, 
		provoquera une famine et fera diminuer votre population. Durant l’antiquité un habitant sur dix est généralement un paysan.</div>
		</li>
		<li>
		<div class="ruleHeader">La servitude</div>
		<div class="ruleMessage">Dans l’Égypte antique, les familles les plus riches peuvent acheter la vie de certains individus, souvent d’anciens prisonniers
		 de guerre ou leurs descendants, pour augmenter leur confort de vie. Si ces puissantes familles estiment que vous ne les privilégiez pas en leur permettant 
		 d’avoir quelques domestiques, alors ils risquent de comploter contre vous.</div>
		</li>
		</ul>	
		
		<div class="ruleHeader">Le choix d’une technologie</div>
		<div class="ruleMessage">
		Pendant les années où votre société se développe, certains de vos habitants vont faire de nouvelles découvertes pour rendre la vie de la cité plus facile.
		</div>
		
		<ul>
		<li>
		<div class="ruleHeader">La poterie</div>
		<div class="ruleMessage">Bien qu’il soit vraiment très utile d’avoir des vases et autres récipients pour contenir des denrées, cette technologie n’améliore 
		pas la gestion globale de la cité mais offre un bonus à vos marchands et artisans.</div>
		</li>
		<li>
		<div class="ruleHeader">L’écriture</div>
		<div class="ruleMessage">Découverte incontournable, elle permet l’organisation de la vie en société et l’apparition du scribe qui permettra d’optimiser
		 efficacement les récoltes et donc d’augmenter considérablement la quantité de nourriture produite.</div>
		</li>
		<li>
		<div class="ruleHeader">Le grenier</div>
		<div class="ruleMessage">Le grenier permet un stockage des ressources alimentaires plus efficace. Il apporte donc un bonus aux paysans.</div>
		</li>
		</ul>
		<div class="ruleHeader">L’écran des scores</div>
		<div class="ruleMessage">Ici vous pouvez réaliser si vous avez créé une société prospère et puissante. N’hésitez pas à recommencer une partie pour tenter
		 d’améliorer votre score en prenant de nouvelles décisions.</div>
       </div>
        <div style="clear:both;"></div>
        <div id='backButton'>
<!--     <input type='button' value='Back' name='Rules' class='mainButtons link' />  -->
    <input type='button' value='<?php echo gettext('Exit game');?>' name='startMenu'  class='mainButtons link'  />
    </div>
    </div>
    


</body>
</html>
