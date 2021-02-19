<?php
if(isset($_GET["machine1"]) && !empty($_GET["system1"])){
    $machine = $_GET["machine1"];
    $system = $_GET["system1"];
    
    chdir('C:/Program Files/Oracle/VirtualBox');

    shell_exec('vboxmanage startvm "'.$machine.'"');

    header('Location: index.php');
}
?>