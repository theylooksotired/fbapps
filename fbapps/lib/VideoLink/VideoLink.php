<?php
class VideoLink {

	static public function videoId($url) {
    	if (strpos($url, 'vimeo')!==false) {
			sscanf(parse_url($url, PHP_URL_PATH), '/%d', $idVimeo);
	    	return intval($idVimeo);
    	} else {		
	        $videoIdLength = 11;
	        $idStarts = strpos($url, "v=");
	        if($idStarts !== FALSE) {
	            $idStarts +=2;
	            return substr($url, $idStarts, $videoIdLength);
	        }
    	}
    }

    static public function videoImage($url) {
		$videoId = VideoLink::videoId($url);
		if ($videoId!='') {
	    	if (strpos($url, 'vimeo')!==false) {
	    		$infoUrl = 'http://vimeo.com/api/v2/video/'.$videoId.'.json';
	    		$contents = @file_get_contents($infoUrl);
	    		if ($contents!='') {
			    	$json = json_decode($contents);
					return '<img src="'.$json[0]->{'thumbnail_large'}.'" alt=""/>';
	    		}
	    	} else {
				return '<img src="http://img.youtube.com/vi/'.$videoId.'/0.jpg" alt=""/>';
	    	}
		}
	}

	static public function videoImageUrl($url) {
		$videoId = VideoLink::videoId($url);
		if ($videoId!='') {
	    	if (strpos($url, 'vimeo')!==false) {
	    		$infoUrl = 'http://vimeo.com/api/v2/video/'.$videoId.'.json';
		    	$json = json_decode(@file_get_contents($infoUrl));
		    	return (is_object($json[0])) ? $json[0]->{'thumbnail_large'} : '';
	    	} else {
				return 'http://img.youtube.com/vi/'.$videoId.'/0.jpg';
	    	}
		}
	}

	static public function renderPlayer($url, $options=array()) {
		$videoId = VideoLink::videoId($url);
		if ($videoId!='') {
	    	if (strpos($url, 'vimeo')!==false) {
				$video = VideoLink::showPlayerVimeo($videoId, $options);
	    	} else {
				$video = VideoLink::showPlayerYoutube($videoId, $options);
	    	}			
	    	return '<div class="videoResponsive">'.$video.'</div>';
		}
	}

	static public function showPlayerYoutube($id, $options=array()) {
		$width = (isset($options['width'])) ? $options['width'] : '100%';
		$height = (isset($options['height'])) ? $options['height'] : '440';
		$autoplay = (isset($options['autoplay'])) ? '&autoplay='.$options['autoplay'] : '';
		return '<div style="width:'.$width.';height:'.$height.';">
					<embed src="//www.youtube.com/v/'.$id.'?'.$autoplay.'" wmode="transparent" type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" frameborder="0" allowfullscreen></embed>
				</div>';
		return '<iframe width="'.$width.'" height="'.$height.'" src="//www.youtube.com/embed/'.$id.$autoplay.'" frameborder="0" allowfullscreen></iframe>';
		return '<iframe src="//www.youtube.com/embed/'.$id.$autoplay.'" frameborder="0" allowfullscreen></iframe>';
	}

	static public function showPlayerVimeo($id, $options=array()) {
		$width = (isset($options['width'])) ? $options['width'] : '100%';
		$height = (isset($options['height'])) ? $options['height'] : '440';
		$autoplay = (isset($options['autoplay'])) ? ' autoplay=1 ' : '';
		return '<object width="'.$width.'" height="'.$height.'">
					<param name="allowfullscreen" value="true" />
					<param name="allowscriptaccess" value="always" />
					<param name="movie" value="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&server=vimeo.com&show_title=1&show_byline=1&show_portrait=0&color=00adef&fullscreen=1" />
					<embed src="http://vimeo.com/moogaloop.swf?clip_id='.$id.'&server=vimeo.com&show_title=1&show_byline=1&show_portrait=0&color=00adef&fullscreen=1" type="application/x-shockwave-flash" allowfullscreen="true" allowscriptaccess="always" width="'.$width.'" height="'.$height.'"></embed>
				</object>';
		return '<iframe src="http://player.vimeo.com/video/'.$id.'" width="'.$width.'" height="'.$height.'" frameborder="0" '.$autoplay.' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		return '<iframe src="http://player.vimeo.com/video/'.$id.'" frameborder="0" '.$autoplay.' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
	}

}
?>