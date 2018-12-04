<?php
/**
 * class for display author info div
 *
 * @file
 * @ingroup Extensions
 *
 * @author Pierre Boutet
 */

class Carousel {

	private static $carouselCounter = 0;

	private static function removeNoImages(&$imgs) {
		$first=true;

		$imgsToRemove = array(
			"[[File:No-image-yet.jpg]]"
		);

		$keysToRemove = [];
		foreach ($imgs as $key => $value) {
			if(in_array($value, $imgsToRemove) && ! $first) {
				unset($imgs[$key]);
				continue;
			}
			if (preg_match('/\[\[File:[\|a-zA-Z]*\]\]/', $imgs[$key])){
				unset($imgs[$key]);
				continue;
			}
			if (preg_match('/\[\[File:\{\{\{(.*)\}\}\}[\|a-zA-Z]*\]\]/', $imgs[$key])){
				unset($imgs[$key]);
				continue;
			}

			if (preg_match('/\[\[([a-zA-Z]+):\{\{\{(.*)\}\}\}[\|a-zA-Z]*\]\]/', $imgs[$key])){
				unset($imgs[$key]);
				continue;
			}
			$first=false;
		}
	}


	public static function addParser( $parser, $img1='') {
		global $wgCarouselDisableMouseOver;

		if( ! $wgCarouselDisableMouseOver) {
			$parser->getOutput()->addModules('ext.carousel.js');
		}

		self::$carouselCounter++;
		$carouselId = self::$carouselCounter;

		$imgs = func_get_args ();
		array_shift($imgs);
		self::removeNoImages($imgs);

		$out = '<div data-interval="false" data-ride="carousel" class="carousel" id="myCarousel'.$carouselId.'">';

		$out .= '<div class="carousel-inner">';
		$active = 'active';
		foreach ($imgs as $img) {
			$out .= '<div class="item '.$active.'">'.$img.'</div>';
			$active = '';
		}
		$out .= '</div>';

		if(count($imgs) > 1) {
			// carousel indicator :
			$out .= '<ol class="carousel-indicators">';
			$count = 0;
			$class = 'carousel-thumb active';
			foreach ($imgs as $img) {
				// for video, remove controls in indicators :
				$img = preg_replace('/\[\[(.*)\]\]/i', '[[$1|no-controls|]]', $img);
				$out .= '<li class="'.$class.'" data-slide-to="'.$count.'" data-target="#myCarousel'.$carouselId.'">'.$img.'</li>';
				$class = 'carousel-thumb';
				$count++;
			}
			$out .= '</ol>';
		}

		$out .= '</div>';

		return array( $out );
	}

}