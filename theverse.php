<?php
/*
Plugin Name: theVerse
Plugin URI: http://iknowledge.islamicnature.com
Description: Rewrites Quran 1:1-7 etc into the Surah name and links to iKnowledge.islamicnature.com
Author: Umar Sheikh
Author URI: http://www.indezinez.com
Version: 1.0
*/


// Check for option tvlang
$lang = get_option('tvlang');

if($lang == ""){
add_option("tvlang", 'english', '', 'yes');
}


// Hook for adding admin menus
add_action('admin_menu', 'mt_add_pages');

// action function for above hook
function mt_add_pages() {
    // Add a new submenu under Options:
    add_options_page('theVerse', 'theVerse', 8, 'theverse', 'mt_options_page');
}

// Replace function One
function theVerseOne($text){

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
<option value="azerbaijan" <?php if(get_option('tvlang') == "azerbaijan"){ echo "selected='selected'"; }?>>Azerbaijan</option>
<option value="bosnian" <?php if(get_option('tvlang') == "bosnian"){ echo "selected='selected'"; }?>>Bosnian</option>
<option value="chinese" <?php if(get_option('tvlang') == "chinese"){ echo "selected='selected'"; }?>>Chinese</option>
<option value="chinesesimp" <?php if(get_option('tvlang') == "chinesesimp"){ echo "selected='selected'"; }?>>Chinese Simplified</option>
<option value="dutch" <?php if(get_option('tvlang') == "dutch"){ echo "selected='selected'"; }?>>Dutch</option>
<option value="english" <?php if(get_option('tvlang') == "english"){ echo "selected='selected'"; }?>>English</option>
<option value="englishasad" <?php if(get_option('tvlang') == "englishasad"){ echo "selected='selected'"; }?>>English Asad</option>
<option value="englishpickthall" <?php if(get_option('tvlang') == "englishpickthall"){ echo "selected='selected'"; }?>>English Pickthall</option>
<option value="englishqaribullah" <?php if(get_option('tvlang') == "englishqaribullah"){ echo "selected='selected'"; }?>>English Qaribullah</option>
<option value="englishshakir" <?php if(get_option('tvlang') == "englishshakir"){ echo "selected='selected'"; }?>>English Shakir</option>
<option value="englishtran" <?php if(get_option('tvlang') == "englishtran"){ echo "selected='selected'"; }?>>English Transliteration</option>
<option value="englishus" <?php if(get_option('tvlang') == "englishus"){ echo "selected='selected'"; }?>>English US</option>
<option value="finnish" <?php if(get_option('tvlang') == "finnish"){ echo "selected='selected'"; }?>>Finnish</option>
<option value="french" <?php if(get_option('tvlang') == "french"){ echo "selected='selected'"; }?>>French</option>
<option value="german" <?php if(get_option('tvlang') == "german"){ echo "selected='selected'"; }?>>German</option>
<option value="indonesian" <?php if(get_option('tvlang') == "indonesian"){ echo "selected='selected'"; }?>>Indonesian</option>
<option value="italian" <?php if(get_option('tvlang') == "italian"){ echo "selected='selected'"; }?>>Italian</option>
<option value="japanese" <?php if(get_option('tvlang') == "japanese"){ echo "selected='selected'"; }?>>Japanese</option>
<option value="korean" <?php if(get_option('tvlang') == "korean"){ echo "selected='selected'"; }?>>Korean</option>
<option value="latin" <?php if(get_option('tvlang') == "latin"){ echo "selected='selected'"; }?>>Latin</option>
<option value="malaysian" <?php if(get_option('tvlang') == "malaysian"){ echo "selected='selected'"; }?>>Malaysian</option>
<option value="mexican" <?php if(get_option('tvlang') == "mexican"){ echo "selected='selected'"; }?>>Mexican</option>
<option value="persian" <?php if(get_option('tvlang') == "persian"){ echo "selected='selected'"; }?>>Persian</option>
<option value="polish" <?php if(get_option('tvlang') == "polish"){ echo "selected='selected'"; }?>>Polish</option>
<option value="portuguese" <?php if(get_option('tvlang') == "portuguese"){ echo "selected='selected'"; }?>>Portuguese</option>
<option value="russian" <?php if(get_option('tvlang') == "russian"){ echo "selected='selected'"; }?>>Russian</option>
<option value="spanish" <?php if(get_option('tvlang') == "spanish"){ echo "selected='selected'"; }?>>Spanish</option>
<option value="swahili" <?php if(get_option('tvlang') == "swahili"){ echo "selected='selected'"; }?>>Swahili</option>
<option value="tamil" <?php if(get_option('tvlang') == "tamil"){ echo "selected='selected'"; }?>>Tamil</option>
<option value="thai" <?php if(get_option('tvlang') == "thai"){ echo "selected='selected'"; }?>>Thai</option>
<option value="turkish" <?php if(get_option('tvlang') == "turkish"){ echo "selected='selected'"; }?>>Turkish</option>
</select>

<p class="submit">
<input type="submit" value="Save" name="save" />
</p>
</form>
</div>

<?php
}

?>
