<?php

$bn = explode('/', $_SERVER['REQUEST_URI'])[2];
header('Content-type: image/' . pathinfo('../../../huesio_storage/media/' . $bn, PATHINFO_EXTENSION));
echo file_get_contents('../../../huesio_storage/media/' . $bn);

?>