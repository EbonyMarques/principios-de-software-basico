<?php
    $machineToClone = $_POST['machineToClone'];
    $cloneMachineName = $_POST['cloneMachineName'];
    $cloneMachineMemorySize = $_POST['cloneMachineMemorySize'];
    $cloneMachineCpuSize = $_POST['cloneMachineCpuSize'];

    // var_dump($machineToClone);
    // var_dump($cloneMachineName);
    // var_dump($cloneMachineMemorySize);
    // var_dump($cloneMachineCpuSize);

    chdir('C:/Program Files/Oracle/VirtualBox');

    shell_exec('VBoxManage clonevm "'.$machineToClone.'" --name="'.$cloneMachineName.'" --register --mode=all');
    shell_exec('VBoxManage modifyvm "'.$cloneMachineName.'" --memory='.$cloneMachineMemorySize.' --cpus='.$cloneMachineCpuSize);
 
    header('Location: index.php');
?>
