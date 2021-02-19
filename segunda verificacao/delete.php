<?php
if(isset($_GET["machine2"])){
    $machine = $_GET["machine2"];
    
    chdir('C:/Program Files/Oracle/VirtualBox');

    $result1 = shell_exec('vboxmanage modifyvm "'.$machine.'" -hda none');
    $result2 = shell_exec('vboxmanage unregistervm "'.$machine.'" --delete');

    header('Location: index.php');
}
?>
