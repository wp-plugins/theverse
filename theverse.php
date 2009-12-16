<?php
/*
Plugin Name: theVerse
Plugin URI: http://iknowledge.islamicnature.com/extras.php
Description: Rewrites Quran 1:1-7 etc into the Surah name and links to iKnowledge.islamicnature.com
Author: Umar Sheikh
Author URI: http://www.indezinez.com
Version: 1.2
*/


// Check for option tvlang
$lang = get_option('tvlang');

if($lang == ""){
	add_option("tvlang", 'english', '', 'yes');
}

if($lang == "englishahmed" || $lang == "englishali" || $lang == "englishamatul" || $lang == "englisharberry" || $lang == "englishasad" || $lang == "englishdaryabadi" || $lang == "englishfaridul" || $lang == "englishhamid" || $lang == "englishmaulana" || $lang == "englishmuhammed" || $lang == "englishpickthall" || $lang == "englishqaribullah" || $lang == "englishshakir" || $lang == "englishus" || $lang == "englishyusuf"){
	update_option('tvlang', 'english');
}

// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages(){
	// Add a new submenu under Options:
	add_options_page('theVerse', 'theVerse', 8, 'theverse', 'mt_options_page');
}

// Replace function One
function theVerseOne($text){

	// Removed langs fix
	if(get_option('tvlang') == "englishahmed" || get_option('tvlang') == "englishali" || get_option('tvlang') == "englishamatul" || get_option('tvlang') == "englisharberry" || get_option('tvlang') == "englishasad" || get_option('tvlang') == "englishdaryabadi" || get_option('tvlang') == "englishfaridul" || get_option('tvlang') == "englishhamid" || get_option('tvlang') == "englishmaulana" || get_option('tvlang') == "englishmuhammed" || get_option('tvlang') == "englishpickthall" || get_option('tvlang') == "englishqaribullah" || get_option('tvlang') == "englishshakir" || get_option('tvlang') == "englishus" || get_option('tvlang') == "englishyusuf"){
		update_option('tvlang', 'english');
	}

	preg_match_all('[\([Qq]uran [0-9]{1,3}[:.][0-9]{1,3}\)]', $text, $matches);

	$matchesone = $matches[0];
	$matchestwo = $matches[0];
	$matchesthree = $matches[0];
	$matcheslast = $matches[0];

	while(list ($key, $val) = each ($matchesone)){

	$matches_left_final[$key] = preg_replace(array("[[:.][0-9]{1,3}\)]","[\([Qq]uran ]"),"",$matches[0][$key]);

	}

	while(list ($key, $val) = each ($matchestwo)){

	$matches_right_final[$key] = preg_replace(array("[\([Qq]uran [0-9]{1,3}[:.]]", "[\)]"),"",$matches[0][$key]);

	}

	while(list ($key, $val) = each ($matchesthree)){

	$matches_final[$key] = "(<a target='_blank' href='http://iknowledge.islamicnature.com/quran/snum/".$matches_left_final[$key]."/vnum/".$matches_right_final[$key]."/lang/".get_option('tvlang')."/'>Quran ".$matches_left_final[$key].":".$matches_right_final[$key]."</a>)";

	}

	$textdone = str_replace($matcheslast, $matches_final, $text);

	return $textdone;

}

// Replace function Two
function theVerseTwo($text){

	// Removed langs fix
	if(get_option('tvlang') == "englishahmed" || get_option('tvlang') == "englishali" || get_option('tvlang') == "englishamatul" || get_option('tvlang') == "englisharberry" || get_option('tvlang') == "englishasad" || get_option('tvlang') == "englishdaryabadi" || get_option('tvlang') == "englishfaridul" || get_option('tvlang') == "englishhamid" || get_option('tvlang') == "englishmaulana" || get_option('tvlang') == "englishmuhammed" || get_option('tvlang') == "englishpickthall" || get_option('tvlang') == "englishqaribullah" || get_option('tvlang') == "englishshakir" || get_option('tvlang') == "englishus" || get_option('tvlang') == "englishyusuf"){
		update_option('tvlang', 'english');
	}

	preg_match_all('[\([Qq]uran [0-9]{1,3}[:.][0-9]{1,3}-[0-9]{1,3}\)]', $text, $matches);

	$matchesone = $matches[0];
	$matchestwo = $matches[0];
	$matchesthree = $matches[0];
	$matchesx = $matches[0];
	$matcheslast = $matches[0];

	while(list ($key, $val) = each ($matchesone)){

	$matches_left_final[$key] = preg_replace(array("[[:.][0-9]{1,3}-[0-9]{1,3}\)]","[\([Qq]uran ]"),"",$matches[0][$key]);

	}

	while(list ($key, $val) = each ($matchestwo)){

	$matches_right_final[$key] = preg_replace(array("[\([Qq]uran [0-9]{1,3}[:.]]", "[-[0-9]{1,3}\)]"),"",$matches[0][$key]);

	}

	while(list ($key, $val) = each ($matchesx)){

	$matches_rightx_final[$key] = preg_replace(array("[[:.][0-9]{1,3}]","[\([Qq]uran [0-9]{1,3}]","[\)]"),"",$matches[0][$key]);

	}

	while(list ($key, $val) = each ($matchesthree)){

	$matches_final[$key] = "(<a target='_blank' href='http://iknowledge.islamicnature.com/quran/snum/".$matches_left_final[$key]."/vnum/".$matches_right_final[$key].str_replace("-","/",$matches_rightx_final[$key])."/lang/".get_option('tvlang')."/'>Quran ".$matches_left_final[$key].":".$matches_right_final[$key].$matches_rightx_final[$key]."</a>)";

	}

	$textdone = str_replace($matcheslast, $matches_final, $text);

	return $textdone;

}

// Replace function three
function theVerseThree($text){

	include("surahnames.php");
	return $text;

}

// Activate theVerse plugin
add_filter('the_content', 'theVerseOne');
add_filter('the_content', 'theVerseTwo');
add_filter('the_content', 'theVerseThree');

// mt_options_page() displays the page content for the Test Options submenu
function mt_options_page() {

if($_POST['lang'] == ""){
}
else
{

$lang = trim(stripslashes($_POST['lang']));

if($lang == ""){
add_option("tvlang", 'english', '', 'yes');
$successful = "<div id='message' class='updated fade'><p>Settings saved successfully</p></div>";
}
else
{
update_option('tvlang', $lang);
$successful = "<div id='message' class='updated fade'><p>Settings saved successfully</p></div>";
}

}

?>

<div class="wrap">

<?php echo $successful; ?>

<h2>theVerse Options</h2>

<p>
This plugin rewrites (Quran 1:1-7) etc into the Surah name and links to iKnowledge.islamicnature.com. For 
example if you write (Quran 1:1-7) (<b>curly brackets are necessary</b>), it will rewrite to Surah 
Al-Fatihah 1:1-7. You can either write Quran or quran and have a ":" or "." in the code.
</p>

<form action="#" method="post">

<b>Change Language:</b><br />
<select style="width:190px;" name="lang">
<option value="english">Choose Language</option>
<option value="albanianfeti" <?php if(get_option('tvlang') == 'albanianfeti'){ echo "selected='selected'"; }?>>Albanian: Feti Mehdiu</option>
<option value="albanianhasan" <?php if(get_option('tvlang') == 'albanianhasan'){ echo "selected='selected'"; }?>>Albanian: Hasan Nahi</option>
<option value="albaniansherif" <?php if(get_option('tvlang') == 'albaniansherif'){ echo "selected='selected'"; }?>>Albanian: Sherif Ahmeti</option>
<option value="azerbaijan" <?php if(get_option('tvlang') == 'azerbaijan'){ echo "selected='selected'"; }?>>Azerbaijan</option>
<option value="azerbaijanmusayev" <?php if(get_option('tvlang') == 'azerbaijanmusayev'){ echo "selected='selected'"; }?>>Azerbaijan: Musayev</option>
<option value="bangla" <?php if(get_option('tvlang') == 'bangla'){ echo "selected='selected'"; }?>>Bangla</option>
<option value="bosnian" <?php if(get_option('tvlang') == 'bosnian'){ echo "selected='selected'"; }?>>Bosnian</option>
<option value="bosniankorkut" <?php if(get_option('tvlang') == 'bosniankorkut'){ echo "selected='selected'"; }?>>Bosnian: Korkut</option>
<option value="bosnianmustafa" <?php if(get_option('tvlang') == 'bosnianmustafa'){ echo "selected='selected'"; }?>>Bosnian: Mustafa</option>
<option value="bulgarian" <?php if(get_option('tvlang') == 'bulgarian'){ echo "selected='selected'"; }?>>Bulgarian</option>
<option value="chinese" <?php if(get_option('tvlang') == 'chinese'){ echo "selected='selected'"; }?>>Chinese</option>
<option value="chinesesimp" <?php if(get_option('tvlang') == 'chinesesimp'){ echo "selected='selected'"; }?>>Chinese: Simplified</option>
<option value="czeckhrbek" <?php if(get_option('tvlang') == 'czeckhrbek'){ echo "selected='selected'"; }?>>Czeck: Hrbek</option>
<option value="czecknykl" <?php if(get_option('tvlang') == 'czecknykl'){ echo "selected='selected'"; }?>>Czeck: Nykl</option>
<option value="dutch" <?php if(get_option('tvlang') == 'dutch'){ echo "selected='selected'"; }?>>Dutch</option>
<option value="dutchkeyzer" <?php if(get_option('tvlang') == 'dutchkeyzer'){ echo "selected='selected'"; }?>>Dutch: Keyzer</option>
<option value="english" <?php if(get_option('tvlang') == 'english'){ echo "selected='selected'"; }?>>English</option>
<option value="englishliteral" <?php if(get_option('tvlang') == 'englishliteral'){ echo "selected='selected'"; }?>>English: Literal</option>
<option value="englishtran" <?php if(get_option('tvlang') == 'englishtran'){ echo "selected='selected'"; }?>>English: Transliteration</option>
<option value="finnish" <?php if(get_option('tvlang') == 'finnish'){ echo "selected='selected'"; }?>>Finnish</option>
<option value="french" <?php if(get_option('tvlang') == 'french'){ echo "selected='selected'"; }?>>French</option>
<option value="frenchhamidullah" <?php if(get_option('tvlang') == 'frenchhamidullah'){ echo "selected='selected'"; }?>>French: Hamidullah</option>
<option value="german" <?php if(get_option('tvlang') == 'german'){ echo "selected='selected'"; }?>>German</option>
<option value="germanabubenheim" <?php if(get_option('tvlang') == 'germanabubenheim'){ echo "selected='selected'"; }?>>German: Bubenheim - Elyas</option>
<option value="germanaburida" <?php if(get_option('tvlang') == 'germanaburida'){ echo "selected='selected'"; }?>>German: Abu-Rida Muhammad</option>
<option value="germankhoury" <?php if(get_option('tvlang') == 'germankhoury'){ echo "selected='selected'"; }?>>German: Khoury</option>
<option value="germanzaidan" <?php if(get_option('tvlang') == 'germanzaidan'){ echo "selected='selected'"; }?>>German: Zaidan</option>
<option value="hausa" <?php if(get_option('tvlang') == 'hausa'){ echo "selected='selected'"; }?>>Hausa</option>
<option value="indonesian" <?php if(get_option('tvlang') == 'indonesian'){ echo "selected='selected'"; }?>>Indonesian</option>
<option value="indonesianbahasa" <?php if(get_option('tvlang') == 'indonesianbahasa'){ echo "selected='selected'"; }?>>Indonesian: Bahasa</option>
<option value="italian" <?php if(get_option('tvlang') == 'italian'){ echo "selected='selected'"; }?>>Italian</option>
<option value="italianpiccardo" <?php if(get_option('tvlang') == 'italianpiccardo'){ echo "selected='selected'"; }?>>Italian: Piccardo</option>
<option value="japanese" <?php if(get_option('tvlang') == 'japanese'){ echo "selected='selected'"; }?>>Japanese</option>
<option value="korean" <?php if(get_option('tvlang') == 'korean'){ echo "selected='selected'"; }?>>Korean</option>
<option value="kurdi" <?php if(get_option('tvlang') == 'kurdi'){ echo "selected='selected'"; }?>>Kurdi</option>
<option value="latin" <?php if(get_option('tvlang') == 'latin'){ echo "selected='selected'"; }?>>Latin</option>
<option value="malayalam" <?php if(get_option('tvlang') == 'malayalam'){ echo "selected='selected'"; }?>>Malayalam</option>
<option value="malaysian" <?php if(get_option('tvlang') == 'malaysian'){ echo "selected='selected'"; }?>>Malaysian</option>
<option value="maranao" <?php if(get_option('tvlang') == 'maranao'){ echo "selected='selected'"; }?>>Maranao</option>
<option value="mexican" <?php if(get_option('tvlang') == 'mexican'){ echo "selected='selected'"; }?>>Mexican</option>
<option value="norwegianeinar" <?php if(get_option('tvlang') == 'norwegianeinar'){ echo "selected='selected'"; }?>>Norwegian: Einar Berg</option>
<option value="persian" <?php if(get_option('tvlang') == 'persian'){ echo "selected='selected'"; }?>>Persian</option>
<option value="persianalha" <?php if(get_option('tvlang') == 'persianalha'){ echo "selected='selected'"; }?>>Persian: &#1575;&#1604;&#1607;&#1740; &#1602;&#1605;&#1588;&#1607;&#8204; &#1575;&#1740;</option>
<option value="persianhasin" <?php if(get_option('tvlang') == 'persianhasin'){ echo "selected='selected'"; }?>>Persian: &#1581;&#1587;&#1740;&#1606; &#1575;&#1606;&#1589;&#1575;&#1585;&#1740;&#1575;&#1606;</option>
<option value="persianmekaram" <?php if(get_option('tvlang') == 'persianmekaram'){ echo "selected='selected'"; }?>>Persian: &#1605;&#1705;&#1575;&#1585;&#1605; &#1588;&#1740;&#1585;&#1575;&#1586;&#1740;</option>
<option value="polish" <?php if(get_option('tvlang') == 'polish'){ echo "selected='selected'"; }?>>Polish</option>
<option value="polishbielawskiego" <?php if(get_option('tvlang') == 'polishbielawskiego'){ echo "selected='selected'"; }?>>Polish: Bielawskiego</option>
<option value="portuguese" <?php if(get_option('tvlang') == 'portuguese'){ echo "selected='selected'"; }?>>Portuguese</option>
<option value="portugueseelhayek" <?php if(get_option('tvlang') == 'portugueseelhayek'){ echo "selected='selected'"; }?>>Portuguese: El-Hayek</option>
<option value="romanian" <?php if(get_option('tvlang') == 'romanian'){ echo "selected='selected'"; }?>>Romanian</option>
<option value="romaniangeorge" <?php if(get_option('tvlang') == 'romaniangeorge'){ echo "selected='selected'"; }?>>Romanian: George Grigore</option>
<option value="russian" <?php if(get_option('tvlang') == 'russian'){ echo "selected='selected'"; }?>>Russian</option>
<option value="russianone" <?php if(get_option('tvlang') == 'russianone'){ echo "selected='selected'"; }?>>Russian: &#1069;&#1083;&#1100;&#1084;&#1080;&#1088; &#1050;&#1091;&#1083;&#1080;&#1077;&#1074;</option>
<option value="russianthree" <?php if(get_option('tvlang') == 'russianthree'){ echo "selected='selected'"; }?>>Russian: &#1042;&#1072;&#1083;&#1077;&#1088;&#1080;&#1103; &#1055;&#1086;&#1088;&#1086;&#1093;&#1086;&#1074;&#1072;</option>
<option value="russiantwo" <?php if(get_option('tvlang') == 'russiantwo'){ echo "selected='selected'"; }?>>Russian: &#1052;.-&#1053;.&#1054;. &#1054;&#1089;&#1084;&#1072;&#1085;&#1086;&#1074;</option>
<option value="somalialbarwani" <?php if(get_option('tvlang') == 'somalialbarwani'){ echo "selected='selected'"; }?>>Somali: Al-Barwani</option>
<option value="spanish" <?php if(get_option('tvlang') == 'spanish'){ echo "selected='selected'"; }?>>Spanish</option>
<option value="spanishcortes" <?php if(get_option('tvlang') == 'spanishcortes'){ echo "selected='selected'"; }?>>Spanish: Cortes</option>
<option value="swahili" <?php if(get_option('tvlang') == 'swahili'){ echo "selected='selected'"; }?>>Swahili</option>
<option value="swedishrashad" <?php if(get_option('tvlang') == 'swedishrashad'){ echo "selected='selected'"; }?>>Swedish: Rashad Kalifa</option>
<option value="tamil" <?php if(get_option('tvlang') == 'tamil'){ echo "selected='selected'"; }?>>Tamil</option>
<option value="tatar" <?php if(get_option('tvlang') == 'tatar'){ echo "selected='selected'"; }?>>Tatar</option>
<option value="thai" <?php if(get_option('tvlang') == 'thai'){ echo "selected='selected'"; }?>>Thai</option>
<option value="turkish" <?php if(get_option('tvlang') == 'turkish'){ echo "selected='selected'"; }?>>Turkish</option>
<option value="turkishalibulac" <?php if(get_option('tvlang') == 'turkishalibulac'){ echo "selected='selected'"; }?>><?php echo htmlentities('Turkish: Ali Bulaç'); ?></option>
<option value="turkishelmalili" <?php if(get_option('tvlang') == 'turkishelmalili'){ echo "selected='selected'"; }?>>Turkish: Elmal&#305;l&#305; Hamdi Yaz&#305;r</option>
<option value="turkishiskender" <?php if(get_option('tvlang') == 'turkishiskender'){ echo "selected='selected'"; }?>>Turkish: &#304;skender Ali Mihr</option>
<option value="turkishmuhammed" <?php if(get_option('tvlang') == 'turkishmuhammed'){ echo "selected='selected'"; }?>>Turkish: Muhammed Esed</option>
<option value="turkishyasar" <?php if(get_option('tvlang') == 'turkishyasar'){ echo "selected='selected'"; }?>>Turkish: Ya&#351;ar Nuri <?php echo htmlentities('Öztürk'); ?></option>
<option value="urduahmed" <?php if(get_option('tvlang') == 'urduahmed'){ echo "selected='selected'"; }?>>Urdu: &#1575;&#1581;&#1605;&#1583; &#1585;&#1590;&#1575; &#1582;&#1575;&#1606;</option>
<option value="urdujalandhry" <?php if(get_option('tvlang') == 'urdujalandhry'){ echo "selected='selected'"; }?>>Urdu: &#1580;&#1575;&#1604;&#1606;&#1583;&#1729;&#1585;&#1740;</option>
<option value="uzbek" <?php if(get_option('tvlang') == 'uzbek'){ echo "selected='selected'"; }?>>Uzbek: &#1052;&#1091;&#1093;&#1072;&#1084;&#1084;&#1072;&#1076; &#1057;&#1086;&#1076;&#1080;&#1082;</option>
</select>

<p class="submit">
<input type="submit" value="Save" name="save" />
</p>
</form>
</div>

<?php
}

?>
