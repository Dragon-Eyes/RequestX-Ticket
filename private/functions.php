<?php

function h($string = "") {
   /**
    * @author Christoph <christoph@dragoneyes.org> 2019-02-21
    */

	// return htmlspecialchars($string);
	// return htmlspecialchars($string, ENT_COMPAT,'UTF-8', true);
	// return htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1');
	// return htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, 'UTF-8');
	// return utf8_encode(htmlspecialchars($string, ENT_COMPAT | ENT_HTML401, 'ISO-8859-1'));
	return htmlspecialchars($string);
	// return htmlspecialchars( nl2br( $string, false ));
}

function u($string = "") {
   /**
    * @author Christoph <christoph@dragoneyes.org> 2019-02-21
    */

    return urlencode($string);
}

function url_for($script_path) {
   /**
    * @author Christoph <christoph@dragoneyes.org> 2019-02-21
    *
    * @todo returns /index.
    */
    
	if ($script_path[0] != '/') {
		$script_path = "/" . $script_path;
	}
	return WWW_ROOT . $script_path;
}

?>