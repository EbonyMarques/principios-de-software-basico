<?php
chdir('C:/Program Files/Oracle/VirtualBox');
$output = shell_exec('vboxmanage list vms');

// echo "<pre>$output</pre>";
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

$new_machines = array();
$new_uuids = array();

foreach ($machines as $value) {
    array_push($new_machines, (str_replace('⠀',' ',$value)));
}

foreach ($uuids as $value) {
    array_push($new_uuids, (str_replace('⠀','',$value)));
}

// echo '<br>';

// var_dump($new_machines);

// var_dump($uuids);

// var_dump($output);

// var_dump($new_machines[0]);

// $output = shell_exec('"VBoxManage.exe" clonevm "'.$new_machines[0].'" --name="'.$new_machines[0].'a'.'" --register --mode=all');
// $memoriacpu = shell_exec('VBoxManage modifyvm "'.$nome.'" --memory '.$memoria.' --cpus '.$cpu.'');

// return "<pre>$output</pre>";
return array($new_machines, $new_uuids, $original);
?>