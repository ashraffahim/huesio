<?php

header('Content-type: image/' . pathinfo('../../../huesio_storage/media/' . $_GET['q'], PATHINFO_EXTENSION));
echo file_get_contents('../../../huesio_storage/media/' . $_GET['q']);

?>