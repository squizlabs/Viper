<?php

if (isset($_GET['res']) === TRUE) {
    var_dump(file_put_contents(dirname(__FILE__).'/tmp/poll/_jsres.tmp', $_GET['res']));
} else {
    $jsExecCont = file_get_contents(dirname(__FILE__).'/tmp/poll/_jsexec.tmp');
    unlink(dirname(__FILE__).'/tmp/poll/_jsexec.tmp');
    if ($jsExecCont) {
        echo $jsExecCont;
    }
}


?>
