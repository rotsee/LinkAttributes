<?php

class LinkAttributes {

	private function attributeIsAllowed ( $str ) {

		if ( in_array( $str, array( 'rel', 'rev', 'charset ', 'type', 'hreflang', 'itemprop', 'media', 'title', 'accesskey', 'target' ) ) )
			return true;
		else
			return false;

	}

	private function doExtractAttributes ( &$text, &$attribs ) {

		global $wgRequest;
		if ( $wgRequest->getText( 'action' ) == 'edit' ) {
			return false;
		}

		/* No user input */
		if ( null === $text )
			return false;

		/* Extract attributes, separated by | or ¦. /u is for unicode, to recognize the ¦.*/
		$arr = preg_split( '/[|¦]/u', $text );
		$text = array_shift( $arr );

		foreach ( $arr as $a ) {

			$pair = explode( '=', $a );

			/* Only go ahead if we have a aaa=bbb pattern, and aaa i an allowed attribute */
			if ( isset( $pair[1] ) && self::attributeIsAllowed( $pair[0] ) ) {

				/* Add to existing attribute, or create a new */
				if ( isset( $attribs[$pair[0]] ) ) {
					$attribs[$pair[0]] = $attribs[$pair[0]] . ' ' . $pair[1];
				} else {
					$attribs[$pair[0]] = $pair[1];
				}
			}

		}

		return true;

	}

	public function ExternalLink ( &$url, &$text, &$link, &$attribs ) {

		self::doExtractAttributes ( $text, $attribs );
		return true;
	}

	public function InternalLink ( $skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret ) {

		self::doExtractAttributes ( $text, $customAttribs );
		return true;

	}


}
