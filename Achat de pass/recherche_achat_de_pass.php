<?php
require_once "../database/Connect.php";
require_once "../../template/index2.php";
require_once "../../template/fonctions/dateToFrench.php";

$tab = [];

if (isset($_GET['recherche_achat_de_pass'])) {



    $recherche_achat_de_pass = $_GET['recherche_achat_de_pass'];

    $sql =  $db->prepare("SELECT * FROM achat_de_pass ac JOIN carte_sim c WHERE ac.id_carte_sim = c.id_carte_sim AND c.numero_sim ='$recherche_achat_de_pass'  ");
    $sql->execute();
    $result = $sql->rowCount();


    $req_sql_carte_sim = "SELECT * FROM carte_sim";
    $execution_requete_carte_sim = $db->query($req_sql_carte_sim);
}

?>

<div id="page-wrapper" style="min-height: 292px;">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <form class="form-horizontal" data-toggle="validator" role="form" method="get" action="recherche_achat_de_pass.php">
                        <ul class="navbar-nav mr-lg-4 w-100">
                            <li class="nav-item nav-search d-none d-lg-block w-100">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="recherche_achat_de_pass">
                                            <i class="mdi mdi-magnify"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="recherche_achat_de_pass" placeholder="search" aria-describedby="search" id="recherche_achat_de_pass">
                                </div>
                            </li>
                        </ul>
                        <br>
                        <p>
                            <button type="submit" class="btn btn-primary">Recherche </button>
                        </p>

                        <a href="liste_achat_de_pass.php" color="white">Retour</a>

                    </form>

                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="dataTable_wrapper">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>

                                    <th class=" col-sm-2 ">CARTE SIM</th>
                                    <th class=" col-sm-1 ">VOLUME SMS</th>
                                    <th class=" col-sm-1 ">VOLUME DATA(en mo)</th>
                                    <th class=" col-sm-1 ">VOLUME MINUTES</th>
                                    <th class=" col-sm-2 ">MONTANT</th>
                                    <th class=" col-sm-2 ">DATE</th>

                                    <th class=" col-sm-2 ">Action</th>
                                </tr>
                            </thead>
                            <?php while ($row = $sql->fetch(PDO::FETCH_ASSOC)) : ?>
                                <tbody>

                                    <tr>
                                        <td>
                                            <?php

                                            $recup_id_carte_sim = $row['id_carte_sim'];
                                            $verif_table_achat_de_pass = "SELECT * FROM `carte_sim` WHERE `id_carte_sim`='$recup_id_carte_sim'";

                                            $execution_verif_table_achat_de_pass = $db->query($verif_table_achat_de_pass);
                                            $contenu_colonne_achat_de_pass = $execution_verif_table_achat_de_pass->fetch(PDO::FETCH_ASSOC);
                                            echo ($contenu_colonne_achat_de_pass === false ? NULL : $contenu_colonne_achat_de_pass['numero_sim']);
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $row['vol_sms']; ?>
                                        </td>
                                        <td>
                                            <?php echo $row['vol_data']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['vol_min']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['montant_achat']; ?>
                                        </td>
                                        <td>
                                            <?php

                                            $var_date = $row['created_at'];


                                            echo dateToFrench($var_date, 'l j F Y H:m:s'); ?>
                                        </td>

                                        <td>
                                            <a type="button" class="btn btn-warning" href="modifierachat_pass.php?id_achat=<?php echo $row['id_achat']; ?>&montant_achat=<?php echo $row['montant_achat']; ?>&created_at=<?php echo $row['created_at']; ?>  "><i class="fa fa-edit fa-lg"></i> Editer</a>
                                            <a type="button" class="btn btn-danger" href="liste_achat_de_pass.php?id_achat=<?php echo $row['id_achat']; ?>"><i class="fa fa-trash fa-lg"></i> Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>

                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->