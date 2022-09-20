<?php
require_once "../database/Connect.php";
require_once "../../template/index2.php";
require_once "../../template/fonctions/style.php";
require_once "../../template/fonctions/Regex.php";

style("achat_de_pass", "color");

$sql1 = "SELECT id_carte_sim, numero_sim FROM carte_sim ";

$stmt1 = $db->query($sql1);



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<div id="page-wrapper" style="min-height: 292px;" class="achat_de_pass">

    <div class="row">
        <div class="col-lg-12 col-md-12">
            <h3 align="center" class="color"> MODIFIER UN ACHAT DE PASS </h3>

            <div class="panel panel-primary">

                <form class="form-horizontal" data-toggle="validator" role="form" method="post" align="center">
                    <p></p>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="col-xs-5">
                                <!--<form class="form-horizontal" role="form">-->


                                <div class="form-group">
                                    <label class=" col-sm-4 control-label"><b>
                                            <h4>CARTE SIM:</h4>
                                        </b></label>
                                    <div class="container">
                                        <select name="id_carte_sim" class="form-control" required>
                                            <option selected value> Selectionner un numero </option>
                                            <?php while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)) : ?>

                                                <option value="<?php echo $row['id_carte_sim']; ?>"><?php echo $row['numero_sim']; ?></option>





                                            <?php endwhile; ?>

                                        </select>
                                    </div>
                                </div>




                                <div class="form-group">
                                    <label class=" col-sm-4 control-label"><b>
                                            <h4>TYPE PASS :</h4>
                                        </b></label>
                                    <div class="container">
                                        <select name="type_pass" class="form-control selected" required>
                                            <option disabled selected value> Selectionner un pass </option>


                                            <option value="SMS">SMS</option>
                                            <option value="MINUTES_SMS">SMS & MINUTES</option>
                                            <option value="SMS_DATA">SMS & DATA</option>
                                            <option value="DATA">DATA</option>
                                            <option value="DATA_MINUTES">DATA & MINUTES</option>
                                            <option value="SMS_DATA_MINUTES">SMS & DATA & MINUTES</option>
                                            <option value="MINUTES">MINUTES</option>





                                        </select>



                                    </div>




                                </div>

                                <div class="form-group">
                                    <label class=" col-sm-4 control-label"><b>
                                            <h4>VOLUME :</h4>
                                        </b></label>
                                    <div class="col-sm-12">
                                        <div class="container ">
                                            <div class="row">
                                                <div class="col-sm-4">

                                                    <input type="text" class="form-control hidden_sms" name="vol_sms" id="vol_sms" placeholder="volume sms" pattern="[0-9]+" value="<?php if (isset($_GET['vol_sms']) && !empty($_GET['vol_sms'])) {
                                                                                                                                                                                            echo $_GET['vol_sms'];
                                                                                                                                                                                        } ?>" required>
                                                </div>

                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control hidden_min " name="vol_min" id="vol_min" placeholder=" volume minute" pattern="[0-9]+" value="<?php
                                                                                                                                                                                                    if (isset($_GET['vol_min']) && !empty($_GET['vol_min'])) {
                                                                                                                                                                                                        echo $_GET['vol_min'];
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control hidden_data " name="vol_data" id="vol_data" placeholder="volume data(en Mo)" pattern="[0-9]+" value="<?php
                                                                                                                                                                                            if (isset($_GET['vol_data']) && !empty($_GET['vol_data'])) {
                                                                                                                                                                                                echo $_GET['vol_data'];
                                                                                                                                                                                               } ?>" required>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </div>
                            <div class="col-xs-5">

                                <div class="form-group">
                                    <label class=" col-sm-4 control-label"><b>
                                            <h4>MONTANT :</h4>
                                        </b></label>
                                    <div class="container">

                                        <input type="text" class="form-control" name="montant" id="montant" pattern="[0-9]+" value="<?php echo $_GET['montant_achat']  ?>" required>
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="enregistrer">Valider </button>



                                    </div>
                                </div>

                            </div>











                        </div><!--  col-xs-5-->
                    </div>
            </div>

</html>


<script>
    //recupère les inputs dans les varibales grace à leur classe
    var hidden_sms = document.querySelector('.hidden_sms');
    var hidden_min = document.querySelector('.hidden_min');
    var hidden_data = document.querySelector('.hidden_data');

    //recupère l'element selectionné avec querySelector
    var selected = document.querySelector('.selected');



    selected.addEventListener('change', () => {


        if (selected.value == "SMS") {

            hidden_data.type = "hidden";
            hidden_min.type = "hidden";

            // Selectionne l'element caché et affiche 
            if (selected.value == "SMS") {
                hidden_sms.type = "text";
                hidden_sms.style.position = "relative";
                hidden_sms.style.right = "-150px";
            }

        } else if (selected.value == "MINUTES") {

            hidden_sms.type = "hidden";
            hidden_data.type = "hidden";

            if (selected.value == "MINUTES") {
                hidden_min.type = "text";
                hidden_min.style.position = "relative";
                hidden_min.style.left = "-8px";
            }

        } else if (selected.value == "MINUTES_SMS") {

            hidden_data.type = "hidden";

            if (selected.value == "MINUTES_SMS") {

                hidden_sms.type = "text";
                hidden_min.type = "text";
                hidden_sms.style.position = "relative";
                hidden_sms.style.right = "-73px";
                hidden_min.style.position = "relative";
                hidden_min.style.right = "-45%";



            }

        } else if (selected.value == "DATA") {

            hidden_min.type = "hidden";
            hidden_sms.type = "hidden";


            if (selected.value == "DATA") {

                hidden_data.type = "text";
                hidden_data.style.position = "relative";
                hidden_data.style.left = "-160px";
            }

        } else if (selected.value == "SMS_DATA") {

            hidden_min.type = "hidden";

            if (selected.value === "SMS_DATA") {
                hidden_sms.type = "text";
                hidden_sms.style.position = "relative";
                hidden_sms.style.right = "-73px";
                hidden_data.type = "text";
                hidden_data.style.position = "relative";
                hidden_data.style.left = "-60%";
            }

        } else if (selected.value == "DATA_MINUTES") {

            hidden_sms.type = "hidden";


            if (selected.value == "DATA_MINUTES") {
                hidden_data.type = "text";
                hidden_min.type = "text";
                hidden_data.style.position = "relative";
                hidden_data.style.left = "-190%";
                hidden_min.style.position = "relative";
                hidden_min.style.left = "75px";
            }
            /* Si l'element que tu as selectionné  est egal à SMS_DATA_MINUTES ALORS affcihe les champs sms et data et minutes */
        } else if (selected.value == "SMS_DATA_MINUTES") {

            hidden_sms.type = "text";

            hidden_data.type = "text";

            hidden_min.type = "text";

            if (selected.value == "SMS_DATA_MINUTES") {

                hidden_sms.type = "text";
                hidden_sms.style.position = "relative";
                hidden_data.type = "text";
                hidden_data.style.position = "relative";
                hidden_data.style.left = "-2%";
                hidden_min.type = "text";

            }


        }





    })
</script>

<?php

$sql = null;
$update_achat_de_pass_sms = null;
$update_achat_de_pass_data = null;
$update_achat_de_pass_minute = null;

$tab_error = [];

$tab_success = [];


if (isset($_POST['enregistrer'])) {

    $id_achat = $_GET['id_achat'];
    $type_pass_SMS = $_POST['type_pass'] === "SMS";
    $type_pass_data = $_POST['type_pass'] === "DATA";
    $type_pass_minute = $_POST['type_pass'] === "MINUTES";
    $type_pass_MINUTES_SMS = $_POST['type_pass'] === "MINUTES_SMS";
    $type_pass_SMS_DATA = $_POST['type_pass'] === "SMS_DATA";
    $type_pass_DATA_MINUTES = $_POST['type_pass'] === "DATA_MINUTES";
    $type_pass_SMS_DATA_MINUTES = $_POST['type_pass'] === "SMS_DATA_MINUTES";

    $id_carte_sim = $_POST['id_carte_sim'];



    $date_jour_j = date('Y-m-d');


    $verif_solde_restant_exist = "SELECT * FROM solde_restant WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%'";
    $execution_verif_solde_restant_exist = $db->query($verif_solde_restant_exist);
    $nombre_de_ligne_solde_restant = $execution_verif_solde_restant_exist->rowCount();

    if ((isset($_GET['id_achat']) && isset($_POST['id_carte_sim']) && isset($_POST['type_pass']) && isset($_POST['montant']))) {

        if ($type_pass_SMS === true) {

            if (isset($_POST['vol_sms']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $montant_sms = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */
                $entier_positif_sms = calcul_positif($volume_sms, $montant_sms);


                if ($entier_positif_sms) {


                    $update_achat_de_pass_sms = "UPDATE achat_de_pass SET vol_min=NULL, vol_data=NULL, vol_sms='$volume_sms',montant_achat='$montant_sms', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->query($update_achat_de_pass_sms);


                    $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                    $execution_recup_created_at = $db->query($recup_created_at);

                    while ($last_created_at_sms = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                        $created_at_sms = $last_created_at_sms['created_at'];
                    }


                    $conso_sms = 0;

                    if ($nombre_de_ligne_solde_restant > 0) {

                        $conso_sms = 0;

                        $somme_volume_sms = 0;

                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);

                        while ($achat_de_pass_sms = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {
                            $somme_volume_sms = $achat_de_pass_sms['vol_sms'] + $somme_volume_sms;
                        }

                        echo $somme_volume_sms;
                        die();

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);
                        $consommation_sms = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH);



                        $conso_sms = $consommation_sms['c_sms'] + $somme_volume_sms;

                        $update_conso_sms = "UPDATE consommation SET c_sms = '$conso_sms', created_at = '$created_at_sms' WHERE id_carte_sim = '$id_carte_sim'  ";
                        $execution_update_conso_sms = $db->query($update_conso_sms);
                    }


                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé OK  <br>";
                    echo " </div>";
                    exit;
                }
            }
        }

        if ($type_pass_data === true) {


            if (isset($_POST['vol_data']) && isset($_POST['montant'])) {

                $volume_data = htmlspecialchars($_POST['vol_data']);
                $montant_data = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */
                $entier_positif_data =   calcul_positif($volume_data, $montant_data);

                if ($entier_positif_data) {


                    $update_achat_de_pass_data = "UPDATE achat_de_pass SET vol_min=NULL, vol_sms=NULL, vol_data='$volume_data', montant_achat='$montant_data', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->exec($update_achat_de_pass_data);


                    if ($nombre_de_ligne_solde_restant > 0) {


                        $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                        $execution_recup_created_at = $db->query($recup_created_at);

                        while ($last_created_at_data = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                            $created_at_data = $last_created_at_data['created_at'];
                        }

                        $conso_data = 0;

                        $somme_volume_data = 0;

                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);

                        while ($achat_de_pass_data = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {
                            $somme_volume_data = $achat_de_pass_data['vol_data'] + $somme_volume_data;
                        }

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);

                        while ($consommation_data = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {
                            $conso_data = $consommation_data['c_data'] + $somme_volume_data;
                        }



                        $update_conso_data = "UPDATE consommation SET c_data = '$conso_data', created_at = '$created_at_data' WHERE id_carte_sim = '$id_carte_sim'  ";
                        $execution_update_conso_data = $db->query($update_conso_data);
                    }

                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé   <br>";
                    echo " </div>";
                    exit;
                }
            }
        }

        if ($type_pass_minute === true) {


            if (isset($_POST['vol_min']) && isset($_POST['montant'])) {

                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_minute = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */
                $entier_positif_minute =   calcul_positif($volume_minute, $montant_minute);


                if ($entier_positif_minute) {


                    $update_achat_de_pass_minute = "UPDATE achat_de_pass SET vol_sms=NULL, vol_data=NULL, vol_min='$volume_minute', montant_achat='$montant_minute', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->exec($update_achat_de_pass_minute);

                    if ($nombre_de_ligne_solde_restant > 0) {

                        $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                        $execution_recup_created_at = $db->query($recup_created_at);

                        while ($last_created_at_minute = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                            $created_at_minute = $last_created_at_minute['created_at'];
                        }



                        $conso_min = 0;

                        $somme_volume_minute = 0;

                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);

                        while ($achat_de_pass_minute = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {
                            $somme_volume_minute = $achat_de_pass_minute['vol_min'] + $somme_volume_minute;
                        }

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);

                        while ($consommation_minute = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {
                            $conso_min = $consommation_minute['c_minute'] + $somme_volume_minute;
                        }



                        $update_conso_minute = "UPDATE consommation SET c_minute = '$conso_min', created_at = '$created_at_minute' WHERE id_carte_sim = '$id_carte_sim'  ";
                        $execution_update_conso_minute = $db->query($update_conso_minute);
                    }


                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé   <br>";
                    echo " </div>";
                    exit;
                }
            }
        }

        if ($type_pass_MINUTES_SMS === true) {



            if (isset($_POST['vol_min']) && isset($_POST['vol_sms']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_sms_minute = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */
                $entier_positif_min_sms =   calcul_positif($volume_sms, $volume_minute, $montant_sms_minute);


                if ($entier_positif_min_sms) {



                    $update_achat_de_pass_minute = "UPDATE achat_de_pass SET vol_sms='$volume_sms', vol_data=NULL, vol_min='$volume_minute', montant_achat='$montant_sms_minute', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->exec($update_achat_de_pass_minute);
                    if ($nombre_de_ligne_solde_restant > 0) {


                        $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                        $execution_recup_created_at = $db->query($recup_created_at);

                        while ($last_created_at_sms_minute = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                            $created_at_sms_minute = $last_created_at_sms_minute['created_at'];
                        }

                        //initialisation des sommes
                        $somme_volume_sms = 0;
                        $somme_volume_minute = 0;


                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);

                        while ($achat_de_pass = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {
                            $somme_volume_sms = $achat_de_pass['vol_sms'] + $somme_volume_sms;
                            $somme_volume_minute = $achat_de_pass['vol_min'] + $somme_volume_minute;
                        }

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);

                        while ($consommation_sms_minute = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {
                            $conso_sms = $consommation_sms_minute['c_sms'] + $somme_volume_sms;
                            $conso_min = $consommation_sms_minute['c_minute'] + $somme_volume_minute;
                        }



                        $update_conso_sms_minute = "UPDATE consommation SET c_sms = '$conso_sms', c_minute = '$conso_min', created_at = '$created_at_sms_minute' WHERE id_carte_sim = '$id_carte_sim'  ";
                        $execution_update_conso_sms_minute = $db->query($update_conso_sms_minute);
                    }

                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé   <br>";
                    echo " </div>";
                    exit;
                }
            }
        }

        if ($type_pass_SMS_DATA === true) {



            if (isset($_POST['vol_sms']) && isset($_POST['vol_data']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $volume_data = htmlspecialchars($_POST['vol_data']);
                $montant_sms_data = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */

                $entier_positif_sms_data =   calcul_positif($volume_sms, $volume_data, $montant_sms_data);


                if ($entier_positif_sms_data) {

                    $update_achat_de_pass_sms_data = "UPDATE achat_de_pass SET vol_sms='$volume_sms', vol_data='$volume_data', vol_min=NULL, montant_achat='$montant_sms_data', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->exec($update_achat_de_pass_sms_data);


                    if ($nombre_de_ligne_solde_restant > 0) {



                        $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                        $execution_recup_created_at = $db->query($recup_created_at);

                        while ($last_created_at_sms_data = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                            $created_at_sms_data = $last_created_at_sms_data['created_at'];
                        }


                        //initialisation des sommes
                        $somme_volume_sms = 0;
                        $somme_volume_data = 0;

                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);

                        while ($achat_de_pass = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {
                            $somme_volume_sms = $achat_de_pass['vol_sms'] + $somme_volume_sms;
                            $somme_volume_data = $achat_de_pass['vol_data'] + $somme_volume_data;
                        }

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);


                        while ($consommation_sms_data = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {

                            $conso_sms = $consommation_sms_data['c_sms'] + $somme_volume_sms;
                            $conso_data = $consommation_sms_data['c_data'] + $somme_volume_data;
                        }

                        $update_conso_sms_minute = "UPDATE consommation SET c_sms = '$conso_sms', c_minute = '$conso_min', created_at = '$created_at_sms_minute' WHERE id_carte_sim = '$id_carte_sim'  ";
                        $execution_update_conso_sms_minute = $db->query($update_conso_sms_minute);
                    }

                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé   <br>";
                    echo " </div>";
                    exit;
                }
            }
        }

        if ($type_pass_DATA_MINUTES === true) {


            if (isset($_POST['vol_data']) && isset($_POST['vol_min']) && isset($_POST['montant'])) {

                $volume_data = htmlspecialchars($_POST['vol_data']);
                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_data_minute = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */

                $entier_positif_data_minute =   calcul_positif($volume_data, $volume_minute, $montant_data_minute);

                if ($entier_positif_data_minute) {


                    $update_achat_de_pass_data_minute = "UPDATE achat_de_pass SET vol_sms=NULL, vol_data='$volume_data', vol_min='$volume_minute', montant_achat='$montant_sms_data', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->exec($update_achat_de_pass_data_minute);


                    if ($nombre_de_ligne_solde_restant > 0) {




                        $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                        $execution_recup_created_at = $db->query($recup_created_at);

                        while ($last_created_at_data_minute = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                            $created_at_data_minute = $last_created_at_data_minute['created_at'];
                        }



                        //initialisation des sommes
                        $somme_volume_data = 0;
                        $somme_volume_minute = 0;


                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);


                        while ($achat_de_pass = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {
                            $somme_volume_data = $achat_de_pass['vol_data'] + $somme_volume_data;
                            $somme_volume_minute = $achat_de_pass['vol_min'] + $somme_volume_minute;
                        }

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);

                        while ($consommation_data_minute = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {
                            $conso_data = $consommation_data_minute['c_data'] + $somme_volume_data;
                            $conso_min = $consommation_data_minute['c_minute'] + $somme_volume_minute;
                        }

                        $update_conso_data_minute = "UPDATE consommation SET c_data = '$conso_data',c_minute = '$conso_min', created_at = '$created_at_data_minute' WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_update_conso_data_minute = $db->query($update_conso_data_minute);
                    }

                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé   <br>";
                    echo " </div>";
                    exit;
                }
            }
        }

        if ($type_pass_SMS_DATA_MINUTES === true) {

            if (isset($_POST['vol_sms']) && isset($_POST['vol_data']) && isset($_POST['vol_min']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $volume_data = htmlspecialchars($_POST['vol_data']);
                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_sms_data_minute = htmlspecialchars($_POST['montant']);


                /*  var_dump($dates);
                exit ; */


                $entier_positif_sms_data_minute =   calcul_positif($volume_sms, $volume_data, $volume_minute, $montant_sms_data_minute);

                if ($entier_positif_sms_data_minute) {


                    $update_achat_de_pass_sms_data_minute = "UPDATE achat_de_pass SET vol_sms='$volume_sms', vol_data='$volume_data', vol_min='$volume_minute', montant_achat='$montant_sms_data_minute', id_carte_sim='$id_carte_sim' WHERE  (id_achat ='$id_achat')";
                    $db->exec($update_achat_de_pass_sms_data_minute);

                    if ($nombre_de_ligne_solde_restant > 0) {



                        $recup_created_at = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim'  AND created_at LIKE '%$date_jour_j%' ";
                        $execution_recup_created_at = $db->query($recup_created_at);

                        while ($last_created_at_sms_data_minute = $execution_recup_created_at->fetch(PDO::FETCH_ASSOC)) {
                            $created_at_sms_data_minute = $last_created_at_sms_data_minute['created_at'];
                        }



                        //initialisation des sommes
                        $somme_volume_sms = 0;
                        $somme_volume_data = 0;
                        $somme_volume_minute = 0;


                        $select_all_achat_de_pass = "SELECT * FROM achat_de_pass WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_achat_de_pass = $db->query($select_all_achat_de_pass);


                        while ($achat_de_pass = $execution_select_all_achat_de_pass->fetch(PDO::FETCH_BOTH)) {

                            $somme_volume_sms = $achat_de_pass['vol_sms'] + $somme_volume_sms;
                            $somme_volume_data = $achat_de_pass['vol_data'] + $somme_volume_data;
                            $somme_volume_minute = $achat_de_pass['vol_min'] + $somme_volume_minute;
                        }

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);




                        while ($consommation_sms_data_minute = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {
                            $conso_sms = $consommation_sms_data_minute['c_sms'] + $somme_volume_sms;
                            $conso_data = $consommation_sms_data_minute['c_data'] + $somme_volume_data;
                            $conso_min = $consommation_sms_data_minute['c_minute'] + $somme_volume_minute;
                        }

                        $update_conso_sms_data_minute = "UPDATE consommation SET c_sms= '$conso_sms',c_data = '$conso_data',c_minute = '$conso_min', created_at = '$created_at_sms_data_minute' WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_update_conso_sms_data_minute = $db->query($update_conso_sms_data_minute);
                    }

                    echo "<div class='alert alert-success'>";
                    echo " Modifié avec success ";
                    echo " </div>";
                    exit;
                } else {

                    echo "<div class='alert alert-danger'>";
                    echo  " Nouvel enregistrement refusé   <br>";
                    echo " </div>";
                    exit;
                }
            }
        }
    } elseif (!(isset($_GET['id_achat']) && isset($_POST['id_carte_sim']) && isset($_POST['type_pass']) && isset($_POST['vol'])  && isset($_POST['montant']))) {

        echo "<div class='alert alert-danger'>";
        echo " Modification refusé   <br>";
        echo " </div>";
    }
    /*  if ($_POST['enregistrer'] === "") {
            
            echo "<div class='alert alert-danger'>";
            echo " Champ(s) vide(s)";
            echo " </div>";
        } */
} /* elseif (!(isset( $_POST['id_carte_sim'] ) && isset($_POST['type_pass'])
    && isset($_POST['vol'])  && isset($_POST['montant']) && isset($_POST['dates']))) {


    echo "<div class='alert alert-danger'>";
    echo  " Nouvel enregistrement refusé   <br>";
    echo " </div>";
} */
