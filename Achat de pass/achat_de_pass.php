<?php
require_once "../database/Connect.php";
require_once "../../template/index2.php";
require_once "../../template/fonctions/style.php";
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
            <h3 align="center" class="color"> AJOUTER UN ACHAT </h3>

            <div class="panel panel-primary">

                <form class="form-horizontal" data-toggle="validator" role="form" method="post" action="achat_de_pass_traitement.php" align="center">
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
                                                    <input type="text" class="form-control hidden_sms" name="vol_sms" id="vol_sms" placeholder="volume sms" pattern="[0-9]+" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control hidden_min " name="vol_min" id="vol_min" placeholder=" volume minute" pattern="[0-9]+" required>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control hidden_data " name="vol_data" id="vol_data" placeholder="volume data(en Mo)" pattern="[0-9]+" required>
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

                                        <input type="text" class="form-control" name="montant" id="montant" pattern="[0-9]+" required>
                                        <br>
                                        <button type="submit" class="btn btn-primary" name="enregistrer">Valider </button>

                                    </div>
                                </div>




                            </div>


                </form>












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

<?php if (isset($_GET['error']) && isset($_GET['len'])) {

$error = [];
$nbr = $_GET['len'];

//La fonction parse_str analyse la chaîne de caractères string comme s'il s'agissait des paramètres passés via l'URL. Toutes les variables qu'elle y repère sont alors créées, avec leurs valeurs respectives (ou dans le tableau si result est fourni).
parse_str($_GET['error'], $error);


for ($i = 0; $i <= $nbr - 1; $i++) {

    echo "<div class='alert alert-danger'>";
    echo "<p> $error[$i]</p>";
    echo "</div>";
}

exit;
}
?>



<?php if (isset($_GET['sucess'])) {
$success = $_GET['sucess'];
echo "<div class='alert alert-success'>";
echo "<p>$success</p>";
echo "  </div>";
exit;
} ?>
