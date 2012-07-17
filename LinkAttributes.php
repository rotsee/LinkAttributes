<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'LinksAttributes',
	'version' => '0.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:LinkAttributes',
	'author' => array( 'Leo Wallentin' ),
	'descriptionmsg' => 'linkattr-desc',
);

$wgAutoloadClasses['LinkAttributes'] = dirname( __FILE__ ) . '/LinkAttributes.body.php';
$wgExtensionMessagesFiles['ParserFunctions'] = dirname( __FILE__ ) . '/LinkAttributes.i18n.php';

global $wgHooks;
$wgHooks['LinkerMakeExternalLink'][] = 'LinkAttributes::ExternalLink';
$wgHooks['LinkBegin'][] = 'LinkAttributes::InternalLink';

