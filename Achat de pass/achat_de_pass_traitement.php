<?php
require_once "../database/Connect.php";
require_once "../../template/fonctions/Regex.php";

$tab_error = [];
$tab_success = [];
$sql = null;



if (isset($_POST['enregistrer'])) {



    $type_pass_SMS = $_POST['type_pass'] === "SMS";
    $type_pass_data = $_POST['type_pass'] === "DATA";
    $type_pass_minute = $_POST['type_pass'] === "MINUTES";
    $type_pass_MINUTES_SMS = $_POST['type_pass'] === "MINUTES_SMS";
    $type_pass_SMS_DATA = $_POST['type_pass'] === "SMS_DATA";
    $type_pass_DATA_MINUTES = $_POST['type_pass'] === "DATA_MINUTES";
    $type_pass_SMS_DATA_MINUTES = $_POST['type_pass'] === "SMS_DATA_MINUTES";

    $id_carte_sim = $_POST['id_carte_sim'];



    $date_jour_j = date('Y-m-d');
    /*     echo $date_jour_j ;
    exit; */


    $verif_solde_restant_exist = "SELECT * FROM solde_restant WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%'";
    $execution_verif_solde_restant_exist = $db->query($verif_solde_restant_exist);
    $nombre_de_ligne_solde_restant = $execution_verif_solde_restant_exist->rowCount();


    if ((isset($_POST['id_carte_sim']) && isset($_POST['type_pass']) && isset($_POST['montant']))) {


        if ($type_pass_SMS === true) {



            if (isset($_POST['vol_sms']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $montant_sms = htmlspecialchars($_POST['montant']);



                $entier_positif_sms = calcul_positif($volume_sms, $montant_sms);

             
                if ($entier_positif_sms) {


                    $sql = "INSERT INTO achat_de_pass (vol_sms,montant_achat,id_carte_sim) 
                    VALUES ('$volume_sms','$montant_sms','$id_carte_sim')";
                    $execution_sql = $db->query($sql);

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

                        $select_all_consommation = "SELECT * FROM consommation WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_select_all_consommation = $db->query($select_all_consommation);
                        $consommation_sms = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH);

                        while ($consommation_sms = $execution_select_all_consommation->fetch(PDO::FETCH_BOTH)) {
                            $conso_sms = $consommation_sms['c_sms'] + $somme_volume_sms;
                        }

                        $update_conso_sms = "UPDATE consommation SET c_sms ='$conso_sms', created_at = '$created_at_sms' WHERE id_carte_sim = '$id_carte_sim'  ";
                        $execution_update_conso_sms = $db->query($update_conso_sms);
                    }

                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé OK  <br>");
                }
            }
        }


        if ($type_pass_data === true) {



            if (isset($_POST['vol_data']) && isset($_POST['montant'])) {

                $volume_data = htmlspecialchars($_POST['vol_data']);
                $montant_data = htmlspecialchars($_POST['montant']);


             

                $entier_positif_data = calcul_positif($volume_data, $montant_data);

                if ($entier_positif_data) {


                    $sql = "INSERT INTO achat_de_pass (vol_data,montant_achat,id_carte_sim) 
                    VALUES ('$volume_data','$montant_data','$id_carte_sim')";
                    $db->exec($sql);

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

                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé   <br>");
                }
            }
        }

        if ($type_pass_minute === true) {



            if (isset($_POST['vol_min']) && isset($_POST['montant'])) {

                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_minute = htmlspecialchars($_POST['montant']);

                $entier_positif_minute = calcul_positif($volume_minute, $montant_minute);

                if ($entier_positif_minute) {


                    $sql = "INSERT INTO achat_de_pass (vol_min,montant_achat,id_carte_sim) 
                    VALUES ('$volume_minute','$montant_minute','$id_carte_sim')";
                    $db->exec($sql);

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
                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé   <br>");
                }
            }
        }

        if ($type_pass_MINUTES_SMS === true) {



            if (isset($_POST['vol_min']) && isset($_POST['vol_sms']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_sms_minute = htmlspecialchars($_POST['montant']);

                $entier_positif_sms_minute = calcul_positif($volume_sms, $volume_minute, $montant_sms_minute);

                if ($entier_positif_sms_minute) {


                    $sql = "INSERT INTO achat_de_pass (vol_sms,vol_min,montant_achat,id_carte_sim) 
                    VALUES ('$volume_sms','$volume_minute','$montant_sms_minute','$id_carte_sim')";
                    $db->exec($sql);

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

                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé   <br>");
                }
            }
        }
        if ($type_pass_SMS_DATA === true) {



            if (isset($_POST['vol_sms']) && isset($_POST['vol_data']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $volume_data = htmlspecialchars($_POST['vol_data']);
                $montant_sms_data = htmlspecialchars($_POST['montant']);


                $entier_positif_sms_data = calcul_positif($volume_sms, $volume_data, $montant_sms_data);


                if ($entier_positif_sms_data) {


                    $sql = "INSERT INTO achat_de_pass (vol_sms,vol_data,montant_achat,id_carte_sim) 
                    VALUES ('$volume_sms','$volume_data','$montant_sms_data','$id_carte_sim')";
                    $db->exec($sql);

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

                        $update_conso_sms_data = "UPDATE consommation SET c_sms = '$conso_sms',c_data = '$conso_data', created_at = '$created_at_sms_data' WHERE id_carte_sim = '$id_carte_sim' AND created_at LIKE '%$date_jour_j%' ";
                        $execution_update_conso_sms_data = $db->query($update_conso_sms_data);
                    }

                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé   <br>");
                }
            }
        }

        if ($type_pass_DATA_MINUTES === true) {


            if (isset($_POST['vol_data']) && isset($_POST['vol_min']) && isset($_POST['montant'])) {

                $volume_data = htmlspecialchars($_POST['vol_data']);
                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_data_minute = htmlspecialchars($_POST['montant']);


                $entier_positif_data_minute = calcul_positif($volume_data, $volume_minute, $montant_data_minute);

                if ($entier_positif_data_minute) {


                    $sql = "INSERT INTO achat_de_pass (vol_sms,vol_data,montant_achat,id_carte_sim) 
                    VALUES ('$volume_data','$volume_minute','$montant_data_minute','$id_carte_sim')";
                    $db->exec($sql);

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

                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé   <br>");
                }
            }
        }

        if ($type_pass_SMS_DATA_MINUTES === true) {


            if (isset($_POST['vol_sms']) && isset($_POST['vol_data']) && isset($_POST['vol_min']) && isset($_POST['montant'])) {

                $volume_sms = htmlspecialchars($_POST['vol_sms']);
                $volume_data = htmlspecialchars($_POST['vol_data']);
                $volume_minute = htmlspecialchars($_POST['vol_min']);
                $montant_sms_data_minute = htmlspecialchars($_POST['montant']);


                $entier_positif_sms_data_minute = calcul_positif($volume_sms, $volume_data, $volume_minute, $montant_sms_data_minute);


               


                if ($entier_positif_sms_data_minute) {


                    $sql = "INSERT INTO achat_de_pass (vol_sms,vol_data,vol_min,montant_achat,id_carte_sim) 
                    VALUES ('$volume_sms','$volume_data','$volume_minute','$montant_sms_data_minute','$id_carte_sim')";
                    $db->exec($sql);

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

                    $success = "Nouvel enregistrement crée avec success";
                    header("Location: achat_de_pass.php?sucess=$success");;
                } else {
                    array_push($tab_error, " Nouvel enregistrement refusé   <br>");
                }
            }
        }
    } elseif (!(isset($_POST['id_carte_sim']) && isset($_POST['type_pass']) && isset($_POST['montant']))) {

        array_push($tab_error, " Nouvel enregistrement refusé   <br>");
    }
}

$nbr = count($tab_error);

if ($tab_error) {
    //redirige sur le html

    //Génère une chaîne en encodage URL, construite à partir du tableau indexé ou associatif qu'on lui passe en paramètre.
    $query = http_build_query($tab_error);
    $url = urlencode($query);


    header("Location: achat_de_pass.php?len=$nbr&error=" . $url);
    exit;
}
