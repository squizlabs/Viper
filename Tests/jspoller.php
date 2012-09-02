<?php

if (isset($_GET['res']) === TRUE) {
    file_put_contents(dirname(__FILE__).'/tmp/poll/_jsres.tmp', $_GET['res']);
} else if (file_exists(dirname(__FILE__).'/tmp/poll/_jsexec.tmp') === TRUE) {
    $jsExecCont = file_get_contents(dirname(__FILE__).'/tmp/poll/_jsexec.tmp');
    unlink(dirname(__FILE__).'/tmp/poll/_jsexec.tmp');
    if ($jsExecCont) {
        echo $jsExecCont;
    }
}


?>
