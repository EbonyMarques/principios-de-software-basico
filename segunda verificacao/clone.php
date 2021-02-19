<?php
    function recuperaPropriedade($cloneMachineName) {
        return shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" guestproperty get "'.$cloneMachineName.'" /VirtualBox/GuestInfo/Net/0/V4/IP');
    }
?>

<?php
    $indexOfDataToClone = $_POST['indexOfDataToClone'];
    $cloneMachineName = $_POST['cloneMachineName'];
    $cloneMachineMemorySize = $_POST['cloneMachineMemorySize'];
    $cloneMachineCpuSize = $_POST['cloneMachineCpuSize'];
    $cloneMachineIP = $_POST['cloneMachineIP'];
    $machines = $_POST['machines'];
    $systems = $_POST['systems'];

    shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" clonevm "'.$machines[$indexOfDataToClone].'" --name="'.$cloneMachineName.'" --register --mode=all');
    shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" modifyvm "'.$cloneMachineName.'" --memory='.$cloneMachineMemorySize.' --cpus='.$cloneMachineCpuSize);
    shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" startvm "'.$cloneMachineName.'"');

    $result1 = recuperaPropriedade($cloneMachineName);

    if (strpos($systems[$indexOfDataToClone], 'Windows')) {
        echo 'Windows';
        $username = 'admin';
        $password = '123456789';
        
        while (trim($result1) != ('Value: '.trim($cloneMachineIP))) {
            $result1 = recuperaPropriedade($cloneMachineName);
            $result2 = shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" guestcontrol "'. $cloneMachineName .'" run --username '.$username.' --password '.$password.' --wait-stdout --wait-stderr --exe "C:\Windows\System32\cmd.exe" -- cmd.exe/arg0 /C powershell ' . '"Start-Process -Verb RunAs cmd.exe ' . "'/c netsh interface ip set address name=".'"Ethernet"'. " static " . $cloneMachineIP ." 255.255.255.0 10.0.2.2'" .'"');
            $result3 = shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" guestcontrol "'. $cloneMachineName .'" run --username '.$username.' --password '.$password.' --wait-stdout --wait-stderr --exe "C:\Windows\System32\cmd.exe" -- cmd.exe/arg0 /C powershell ' . '"Start-Process -Verb RunAs cmd.exe ' . "'/c netsh interface ip set dnsserver ".'"Ethernet"'. " static 8.8.8.8" .'"');
        }
    } else {
        echo 'Linux';
        $username = 'root';
        $password = '123456789';
        
        while (trim($result1) != ('Value: '.trim($cloneMachineIP))) {
            $result1 = recuperaPropriedade($cloneMachineName);
            $result2 = shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" --nologo guestcontrol "'.$cloneMachineName.'" run --exe "/sbin/ifconfig" --username '.$username.' --password '.$password.' --wait-stdout -- ifconfig eth0 '.$cloneMachineIP . ' netmask 255.255.255.0');
            $result3 = shell_exec('"C:\Program Files\Oracle\Virtualbox\VBoxManage.exe" --nologo guestcontrol "'.$cloneMachineName.'" run --exe "/sbin/route" --username '.$username.' --password '.$password.' --wait-stdout -- route add default gw 10.0.2.2 eth0');
        }
        
    }

    header('Location: index.php');  
?>