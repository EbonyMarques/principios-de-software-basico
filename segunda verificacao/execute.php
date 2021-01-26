<?php
if(isset($_GET["machine"]) && !empty($_GET["system"])){
    // Get hidden input value
    $machine = $_GET["machine"];
    $system = $_GET["system"];
    
    chdir('C:/Program Files/Oracle/VirtualBox');

    shell_exec('vboxmanage startvm "'.$machine.'"');
    sleep(30);
    $result = shell_exec('vboxmanage --nologo guestcontrol "'.$machine.'" --username ebony --password q1w2e3r4t5A --exe /bin/ls -- ls /home/ebony');

    var_dump($result);

    // header('Location: index.php');
}
?>