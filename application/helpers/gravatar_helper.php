<?php
function gravatar($email='', $size=25, $class='') {
	$hash = md5($email);
	printf('<img src="http://gravatar.com/avatar/%s?s=%d&amp;default=mm" class="%s">', $hash, $size, $class);
}