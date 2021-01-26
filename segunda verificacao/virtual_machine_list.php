<?php
    chdir('C:/Program Files/Oracle/VirtualBox');
    $output = shell_exec('vboxmanage list vms');

    $original = "<pre>$output</pre>";

    $output = str_replace(' ','⠀',$output);
    $count = 1;
    // $output = str_replace('"','',$output,$count);
    $output = preg_split('/\s+/', trim($output));
    $output = preg_replace('/"/', '', $output, $count);


    $machines = array();
    $uuids = array();

    foreach ($output as $value) {
        $result = explode('"', $value, 2);
        array_push($machines, $result[0]);
        array_push($uuids, $result[1]);
    }

    $newMachines = array();
    $newUuids = array();

    foreach ($machines as $value) {
        array_push($newMachines, (str_replace('⠀',' ',$value)));
    }

    foreach ($uuids as $value) {
        array_push($newUuids, (str_replace('⠀','',$value)));

    }

    $machinesOS = array();
    
    foreach ($newMachines as $value) {
        $result = shell_exec('vboxmanage showvminfo "'.$value);
        $result = str_replace('Guest OS: ','⠀',$result);
        $result = str_replace('UUID: ','⠀',$result);
        $result = explode('⠀', $result, 3);
        $result = $result[1];
        array_push($machinesOS, $result);
    }
    

// echo '<br>';

// var_dump($newMachines);

// var_dump($uuids);

// var_dump($output);

// var_dump($newMachines[0]);

// $output = shell_exec('"VBoxManage.exe" clonevm "'.$newMachines[0].'" --name="'.$newMachines[0].'a'.'" --register --mode=all');
// $memoriacpu = shell_exec('VBoxManage modifyvm "'.$nome.'" --memory '.$memoria.' --cpus '.$cpu.'');

// return "<pre>$output</pre>";
    return array($newMachines, $newUuids, $original, $machinesOS);
?>