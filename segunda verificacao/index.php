<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <!-- <link rel="stylesheet" type="text/css" href="css/main.css"> -->
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">

    <title>Clonar máquinas virtuais</title>
</head>

<body>
    <header>
        <div class="navbar navbar-dark bg-dark shadow-sm">
            <div class="container d-flex justify-content-between">
                <a href="#" class="navbar-brand d-flex align-items-center">
                    UFRPE | BSI | Princípios de Software Básico 2020.4
                </a>
                <a href="#" class="navbar-brand d-flex align-items-center">
                    Ebony Marques Rodrigues
                </a>
            </div>
        </div>
    </header>
    <main role="main">
        <section class="jumbotron text-center">
            <div class="container">
                <h1 class="jumbotron-heading">Gerenciador de máquinas virtuais do Oracle VM VirtualBox</h1>
            </div>
        </section>
        <div class="album py-5 bg-light">
            <div class="container">
                <div id="alertResponse"></div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h4>Máquinas virtuais existentes</h4>
                                <div style="height:10px;font-size:1px;">&nbsp;</div>
                                <?php
                                    $result = include("virtual_machine_list.php");
                                    echo '<table style="width:100%">';
                                    echo '<tr>';
                                    echo '<th>Nome da máquina</th>';
                                    echo '<th>UUID</th>';
                                    echo '<th></th>';
                                    echo '</tr>';
                                    $length = count($result[0]);
                                    for ($i = 0; $i < $length; $i++) {
                                        echo '<tr>';
                                        echo '<td>'.$result[0][$i].'</td>';
                                        echo '<td>'.$result[1][$i].'</td>';
                                        // echo '<td>'.$result[3][$i].'</td>';
                                        // echo "<td><a href='execute.php?machine=".$result[0][$i]."&system=".trim($result[3][$i])."' title='Rodar'><i class='fa fa-play-circle-o'></i></a></td>";
                                        echo '<td><form action="execute.php" method="get" id="executeForm" onsubmit="return execute()">
                                                <input type="hidden" id="machine" name="machine" value="'.$result[0][$i].'">
                                                <input type="hidden" id="system" name="system" value="'.$result[3][$i].'">
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="fa fa-play-circle-o"></i></button>
                                              </form></td>';
                                            //   <button type="submit" class="btn btn-primary"><i class="fa fa-play-circle-o"></i></button>
                                        echo '</tr>';
                                    }
                                    // message('sucesso', 'A máquina está sendo clonada. Isto pode demorar um pouco...');
                                    echo '</tr>';
                                    echo '</table>';
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card mb-4 shadow-sm">
                            <div class="card-body">
                                <h4>Clonar máquina virtual</h4>
                                <div style="height:10px;font-size:1px;">&nbsp;</div>
                                <form action="clone.php" method="post" id="cloneMachineForm" onsubmit="return validateForm()">
                                    <div class="form-group">
                                        <label for="machineToClone">Máquina virtual a ser clonada</label>
                                        <select class="form-control" name="machineToClone" id="machineToClone">
                                            <?php
                                                foreach($result[0] as $machine) {
                                                    echo '<option value="'. $machine .'">' . $machine . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cloneMachineName">Nome da nova máquina</label>
                                        <input class="form-control" name="cloneMachineName" id="cloneMachineName" placeholder="Nome da nova máquina...">
                                    </div>
                                    <div class="form-group">
                                        <label for="cloneMachineMemorySize">Quantidade de memória RAM da nova máquina</label>
                                        <input type="range" class="form-control-range" name="cloneMachineMemorySize" id="cloneMachineMemorySize" min="1024" max="8196" value="1024" step="1024">
                                        <span id="cloneMachineMemorySizeOutput">8192</span> MB
                                    </div>
                                    <div class="form-group">
                                        <label for="cloneMachineCpuSize">Quantidade de CPU(s) da nova máquina</label>
                                        <input type="range" class="form-control-range" name="cloneMachineCpuSize" id="cloneMachineCpuSize" min="1" max="4" value="1" step="1">
                                        <span id="cloneMachineCpuSizeOutput">1</span>
                                    </div>
                                    <div class="form-group">
                                        <label for="networkingConfig">Configurações de rede da nova máquina</label>
                                        <select class="form-control" name="networkingConfig" id="networkingConfig">
                                            <option value="nat">NAT</option>
                                            <option value="natnetwork">Rede NAT</option>
                                            <option value="bridged">Placa em modo bridge</option>
                                            <option value="intnet">Rede interna</option>
                                            <option value="hostonly">Host-only</option>
                                            <option value="generic">Driver genérico</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Clonar máquina virtual</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script> -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script>
        var input1 = document.getElementById('cloneMachineMemorySize'),
        output1 = document.getElementById('cloneMachineMemorySizeOutput');
        input1.oninput = function(){
            output1.innerHTML = input1.value;
        };
        input1.oninput();
    </script>
    <script>
        var input2 = document.getElementById('cloneMachineCpuSize'),
        output2 = document.getElementById('cloneMachineCpuSizeOutput');
        input2.oninput = function(){
            output2.innerHTML = input2.value;
        };
        input2.oninput();
    </script>
    <script>
        function validateForm() {
            var cloneMachineName = document.forms["cloneMachineForm"]["cloneMachineName"].value;
            var machineToClone = document.forms["cloneMachineForm"]["machineToClone"].value;

            if (cloneMachineName != '') {
                if (cloneMachineName != machineToClone) {
                    message('sucesso', 'A máquina está sendo clonada. Isto pode demorar um pouco...');
                    return true;
                } else {
                    message('erro', 'O nome da nova máquina não deve ser igual ao nome de uma máquina existente...');
                    return false;
                }
            } else {
                message('erro', 'O campo "Nome da nova máquina" deve ser preenchido...');
                return false;
            }
        }

        function execute() {
            message('iniciando', 'A máquina está sendo iniciada. Isto pode demorar um pouco...');
        }
    </script>
    
    <script>
        function message(alerta, texto) {
            var resposta = '';

            $("#alertResponse").empty();

            if (alerta === 'sucesso') {
                resposta = "<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>" +
                "<a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" +
                texto + "</div>";

            } else if (alerta === 'atencao') {
                resposta = "<div class='alert alert-warning alert-dismissible fade show text-center' role='alert'>" +
                "<a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" +
                texto + "</div>";
            } else if (alerta === 'erro') {

            resposta = "<div class='alert alert-danger alert-dismissible fade show text-center' role='alert'>" +
                "<a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" +
                texto + "</div>";
            } else if (alerta === 'iniciando') {
                resposta = "<div class='alert alert-success alert-dismissible fade show text-center' role='alert'>" +
                "<a href='#' class='close' data-dismiss='alert' aria-label='Close'>&times;</a>" +
                texto + "</div>";
            }

            $("#alertResponse").append(resposta);

        };
    </script>
</body>

</html>