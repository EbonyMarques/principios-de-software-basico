<?php
if(isset($_GET["machine2"])){
    // Get hidden input value
    $machine = $_GET["machine2"];
    
    chdir('C:/Program Files/Oracle/VirtualBox');

    $result1 = shell_exec('vboxmanage modifyvm "'.$machine.'" -hda none');
    $result2 = shell_exec('vboxmanage unregistervm "'.$machine.'" --delete');

    // echo $machine;
    // echo $result1;
    // echo $result2;
    // echo 'wtf';
    // var_dump($result);

    header('Location: index.php');
}
?>
