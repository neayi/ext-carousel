<?php
if ( function_exists( 'wfLoadExtension' ) ) {
	wfLoadExtension( 'Carousel' );
	
	// Keep i18n globals so mergeMessageFileList.php doesn't break
	$wgMessagesDirs['Carousel'] = __DIR__ . '/i18n';
	
	wfWarn(
		'Deprecated PHP entry point used for the Carousel extension. ' .
		'Please use wfLoadExtension() instead, '
	);
	return;
} else {
	die( 'This version of the FooBar extension requires MediaWiki 1.35+' );
}
