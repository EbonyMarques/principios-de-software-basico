@ECHO OFF

SET /a machine_to_clone=%1
SET /a clone_machine_name=%2
SET /a clone_machine_memory_size=%3
SET /a clone_machine_cpu_size=%4
SET /a clone_machine_network_config=%5
SET /a clone_machine_ip=%6
SET /a username=%7
SET /a password=%8

@REM echo %1

cd /d "C:\Program Files\Oracle\VirtualBox"

VBoxManage.exe clonevm %1 --name=%2 --register --mode=all
VBoxManage.exe modifyvm %2 --memory=%3 --cpus=%4 --nic0=%5
VBoxManage.exe startvm %2
VBoxManage.exe --nologo guestcontrol %2 run --exe /sbin/ifconfig --username %7 --password %8 --wait-stdout -- ifconfig eth0 %6 netmask 255.0.0.0



@REM PAUSE

@REM script.bat "Ubuntu 14.04.6 LTS" "Clone" "1024" "1" "nat" "192.168.0.1" "root" "q1w2e3r4t5A"


@REM Machine has been successfully cloned as "Clone de Ubuntu 12.04.5" Waiting for VM "Clone de Ubuntu 12.04.5" to power on... VM "Clone de Ubuntu 12.04.5" has been successfully started.

@REM Machine has been successfully cloned as "Clone de Ubuntu 12.04.5" --------------error