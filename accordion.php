<?php

/**
 * Accordion Plugin for Bootstrap 4.0
 *
 * @author Andy Kramer https://saan.digital
 * @version 1.0.0
 *
 */

kirbytext::$pre[] = function($kirbytext, $text){

  $text = preg_replace_callback('!\(accordion(…|\.{3})\)(.*?)\((…|\.{3})accordion\)!is', function($matches) use($kirbytext) {
	$sections = preg_split('!(\n|\r\n)\~{4}\s+(\n|\r\n)!is', $matches[2]);
	$html = array();
	$i = 1;
	foreach($sections as $section){

		$part1 = '<div class="card"><div id="heading-'.$i.'" class="card-header" role="button" data-toggle="collapse" href="#collapse-'.$i.'" aria-controls="collapse-'.$i.'"><h5>';
		$part2 = '</h5></div><div id="collapse-'.$i.'" class="collapse" data-parent="#accordion" aria-labelledby="heading-'.$i.'"><div class="card-body">';
		$part3 = '</div></div></div>';
		
		$ti = preg_replace('!\(accTitle:(.*?)\).*!is', '${1}', $section );
		$te = preg_replace('!\(accTitle:(.*?)\)(.*)!is', '${2}', $section );
		
		$title = new Field($kirbytext->field->page, null, trim($ti));
		$text = new Field($kirbytext->field->page, null, trim($te));
		
		$html[] = $part1.html($title).$part2.kirbytext($text).$part3;
		
		$i++;
	}
	return '<div id="accordion">'.implode($html).'</div>';

  }, $text);

  return $text;

};
