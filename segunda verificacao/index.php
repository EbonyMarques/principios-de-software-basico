<!doctype html>
<html lang="pt-br">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="css/main.css">

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
                <h1 class="jumbotron-heading">Projeto da Segunda Verificação de Aprendizagem: gerenciador de máquinas
                    virtuais do Oracle VM VirtualBox</h1>
            </div>
        </section>
        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    <div class="col-md-7">
                        <div class="card mb-4 shadow-sm">

                            <div class="card-body">
                                <h4>Máquinas virtuais existentes</h4><br>

                                <?php
                                    $result = include("virtual_machine_list.php");

                                    // echo $result[2];
                                    
                                    echo '<table style="width:100%">';
                                    echo '<tr>';
                                    echo '<th>Nome da máquina</th>';
                                    echo '<th>UUID</th>';
                                    echo '</tr>';

                                    $length = count($result[0]);
                                    for ($i = 0; $i < $length; $i++) {
                                        // print $array[$i];
                                        echo '<tr>';
                                        echo '<td>'.$result[0][$i].'</td>';
                                        echo '<td>'.$result[1][$i].'</td>';
                                        echo '</tr>';
                                    }

                                    // echo '<tr>';
                                    // echo '<td>Jill</td>';
                                    // echo '<td>Smith</td>';
                                    // echo '</tr>';
                                    // echo '<tr>';
                                    // echo '<td>Eve</td>';
                                    // echo '<td>Jackson</td>';
                                    echo '</tr>';
                                    echo '</table>';

                                    // var_dump($result[0]);
                                    // echo '<br><br>';
                                    // var_dump($result[1]);
                                ?>
                                <?php?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="card mb-4 shadow-sm">

                            <div class="card-body">
                                <!-- <p class="card-text">Clonar máquina virtual</p> -->
                                <h4>Clonar máquina virtual</h4><br>

                                <form action="clone.php" method="post">
                                    <div class="form-group">
                                        <label for="machineToClone">Máquina virtual a ser clonada</label>
                                        <select class="form-control" name="machineToClone" id="machineToClone">
                                            <?php
                                                // foreach($countries as $cc => $name) {
                                                //     echo '<option value="' . $cc . '">' . $name . '</option>';
                                                // }

                                                foreach($result[0] as $machine) {
                                                    echo '<option value="'. $machine .'">' . $machine . '</option>';
                                                }
                                            ?>
                                            <!-- <option>Linux (Ubuntu 20.04 LTS)</option>
                                            <option>Windows (10)</option> -->
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="cloneMachineName">Nome da nova máquina</label>
                                        <input class="form-control" name="cloneMachineName" id="cloneMachineName" placeholder="Nome da nova máquina...">
                                    </div>
                                    <!-- <div class="form-group">
                                        <label for="cloneMachineName">Quantidade de memória principal da nova máquina</label>
                                        <input type="email" class="form-control" id="cloneMachineName" placeholder="Entre com um nome para a nova máquina virtual...">
                                    </div> -->
                                    <div class="form-group">
                                        <label for="cloneMachineMemorySize">Quantidade de memória RAM da nova máquina</label>
                                        <input type="range" class="form-control-range" name="cloneMachineMemorySize" id="cloneMachineMemorySize" min="1024" max="8196" value="1024" step="1024">
                                        <span id="cloneMachineMemorySizeOutput">8192</span> MB
                                    </div>
                                    <div class="form-group">
                                        <label for="cloneMachineCpuSize">Quantidade de CPU(s)</label>
                                        <input type="range" class="form-control-range" name="cloneMachineCpuSize" id="cloneMachineCpuSize" min="1" max="4" value="1" step="1">
                                        <span id="cloneMachineCpuSizeOutput">1</span>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>

    <script>
        // var values = [1,3,5,10,20,50,100];    //values to step to
        // var values1 = [1024, 2048, 3072, 4096, 5120, 6144, 7168, 8192];    //values to step to
        var input1 = document.getElementById('cloneMachineMemorySize'),
        output1 = document.getElementById('cloneMachineMemorySizeOutput');

        input1.oninput = function(){
            output1.innerHTML = input1.value;
        };
        input1.oninput(); //set default value

    </script>

    <script>
        var input2 = document.getElementById('cloneMachineCpuSize'),
        output2 = document.getElementById('cloneMachineCpuSizeOutput');

        input2.oninput = function(){
            output2.innerHTML = input2.value;
        };
        input2.oninput(); //set default value
    </script>
    <script>
        var input3 = document.getElementById('machineToClone');
        // console.log(input3);
        console.log(input3.value);
    </script>
</body>

</html>