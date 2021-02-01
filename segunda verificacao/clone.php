<?php
    $machineToClone = $_POST['machineToClone'];
    $cloneMachineName = $_POST['cloneMachineName'];
    $cloneMachineMemorySize = $_POST['cloneMachineMemorySize'];
    $cloneMachineCpuSize = $_POST['cloneMachineCpuSize'];
    $networkingConfig = $_POST['networkingConfig'];
    $cloneMachineIP = $_POST['cloneMachineIP'];

    chdir('C:/Program Files/Oracle/VirtualBox');

    // $result = shell_exec('script.bat "Ubuntu 12.04.5" "Clone de Ubuntu 12.04.5" "4096" "1" "nat" "192.168.0.1" "root" "123456789"');

    shell_exec('VBoxManage clonevm "'.$machineToClone.'" --name="'.$cloneMachineName.'" --register --mode=all');
    shell_exec('VBoxManage modifyvm "'.$cloneMachineName.'" --memory='.$cloneMachineMemorySize.' --cpus='.$cloneMachineCpuSize.' --nic0='.$networkingConfig);
 
    $username = 'root';
    $password = '123456789';
    
    shell_exec('VBoxManage startvm "'.$cloneMachineName.'"');

    function recuperaPropriedade($cloneMachineName) {
        return shell_exec('VBoxManage guestproperty get "'.$cloneMachineName.'" /VirtualBox/GuestInfo/Net/0/V4/IP');
    }

    $result = recuperaPropriedade($cloneMachineName);

    while (trim($result) == 'No value set!') {
        $result = recuperaPropriedade($cloneMachineName);
    }

    shell_exec('VBoxManage --nologo guestcontrol "'.$cloneMachineName.'" run --exe "/sbin/ifconfig" --username '.$username.' --password '.$password.' --wait-stdout -- ifconfig eth1 '.$cloneMachineIP.' netmask 255.0.0.0');
    // shell_exec('VBoxManage controlvm "'.$cloneMachineName.'" savestate');

    header('Location: index.php');
    
?>
