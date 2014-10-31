<?php
require_once '../config.php';
Header("content-type: application/x-javascript");
echo "var word_flavour_king = '" . gettext('In Egypt, the king was called Pharaoh. ' . 
											'He was considered as a god and possessed absolute power over the land.') . "';";
echo "var word_flavour_priest = '" . gettext('The priests take care of the cult of the numerous divinities ' .
											'of the egyptian religion.') . "';";
echo "var word_flavour_craftsmen = '" . gettext('From argile, stone, ivory, bones, wood and metal, the artisanal ' .
											'production of ancient egypt shows a great quality and allow for a ' .
											'very florishing trading.') ."';";
echo "var word_flavour_scribes = '" . gettext('Specialists of writing in the antiquity, the role of scribes was ' .
										'primordial for the optimization of the production in antic societies.') . "';";
echo "var word_flavour_soldiers = '" . gettext('Being a soldier wasn&#39;t very popular in Egypt. The egyptians were mostly ' .
												'peasants. But in order to defend their recolts, they created an army '.
												'that would soon become a professional one.') . "';";
echo "var word_flavour_peasants = '" . gettext('The peasants in antic egypt, like those of the rest of the world, ' . 
												'had the essential task to exploit the soil to feed the population.') . "';";
echo "var word_flavour_slaves = '" . gettext('Slavery is a condition in which an individual has his freedom taken ' .
											'from him. He becomes the possession of another individual who can make ' .
											'him work without pay or sell him.') . "';";
echo "var word_flavour_granary = '" . gettext('A granary is used to stock grains. It appeared around the neolithic ' .
											'revolution, 14,000 years before Christ.') . "';";
echo "var word_flavour_writing = '" . gettext('Writing appeared around the fourth millenial before Jesus Christ. ' .
												'First used for accounting, writing eventually became a mean for ' . 
												'communication and thinking.') . "';";
echo "var word_flavour_pottery = '" . gettext('The invention of pottery comes from prehistory and would have happened ' .
												'in China around 20,000 years before Christ. Its use was mostly domestic ' .
												'and culinary.') . "';";
echo "var word_flavour_caravans = '" .gettext('The egyptians had a very developped trading activity. ' .
													'They would exchange their manufactured products against raw materials ' .
													'from neighbooring cities. Those trades ensured Egypt prosperity.') . "';";

echo "var word_flavour_score_tech = '" .gettext('0.5 points are given for every technology you discovered.') . "';";
echo "var word_flavour_score_wealth = '" .gettext('0.5 points are given for every 500 wealth you possess.') . "';";
echo "var word_flavour_score_building = '" .gettext('0.125 points are given for every building you built.') . "';";
echo "var word_flavour_score_pop = '" .gettext('0.03125 points are given for every 50 citizen.') . "';";
echo "var word_flavour_score_unhappiness = '" .gettext('0.5 points are given if your citizen are happy.') . "';";
echo "var word_flavour_score_total = '" .gettext('The total score is calculated by additioning the other results.') . "';";

echo "var word_flavour_zone1 = '" . gettext('This place is very fertile due to the river that flows through it.') . "';";
echo "var word_flavour_zone2 = '" . gettext('An arid desert lays for miles and miles away.') . "';";
echo "var word_flavour_zone3 = '" . gettext('A desertic chain of mountains.') . "';";
echo "var word_confirm_end_turn = '" . gettext('Do you want to end the turn?') . "';";
echo "var word_confirm_quit_game = '" . gettext('Do you want to quit the game?') . "';";
echo "var word_confirm_map_choice = '" . gettext('Are you sure you want to choose that place to found your city ?') . "';";
echo "var word_yes = '" . gettext('Yes') . "';";
echo "var word_cancel = '" . gettext('Cancel') . "';";

echo "var word_king = '" . gettext('Kings') . "';";
echo "var word_priests = '" . gettext('Priests') . "';";
echo "var word_craftsmen = '" . gettext('Craftsmen') . "';";
echo "var word_scribes = '" . gettext('Scribes') . "';";
echo "var word_soldiers = '" . gettext('Soldiers') . "';";
echo "var word_peasants = '" . gettext('Peasants') . "';";
echo "var word_slaves = '" . gettext('Slaves') . "';";
?>