@ECHO OFF

SET /a INT1=%1
SET /a INT2=%2

SET /a ANSWER=INT1*INT2

ECHO %ANSWER%

PAUSE


@REM VBoxManage.exe clonevm %machine_to_clone% --name=%clone_machine_name% --register --mode=all
@REM VBoxManage.exe modifyvm %clone_machine_name% --memory=%clone_machine_memory_size% --cpus=%clone_machine_cpu_size% --nic0=%clone_machine_network_config%

@REM @REM SET /a ANSWER=INT1*INT2

@REM @REM ECHO %ANSWER%

@REM VBoxManage.exe startvm %~clone_machine_name%
@REM VBoxManage.exe --nologo guestcontrol %~clone_machine_name% run --exe /sbin/ifconfig --username %~username% --password %~password% --wait-stdout -- ifconfig eth0 %~clone_machine_ip% netmask 255.0.0.0







@REM VBoxManage.exe clonevm %1 --name=%2 --register --mode=all
@REM VBoxManage.exe modifyvm %2 --memory=%3 --cpus=%4 --nic0=%5
@REM VBoxManage.exe --nologo guestcontrol %~clone_machine_name% run --exe /sbin/ifconfig --username %~username% --password %~password% --wait-stdout -- ifconfig eth0 %~clone_machine_ip% netmask 255.0.0.0