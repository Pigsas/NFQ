<?php

include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';
$ini = parse_ini_file(getcwd().'/config.ini');
$iv = substr(hash('sha256', $ini['iv']), 0, 16);
$key = hash('sha256', $ini['key']);
if(!empty($_POST['submitClient']))
{
    $client = new Client;
    $client->firstName = $_POST['firstName'];
    $client->lastName = $_POST['lastName'];
    $response = $client->add();
    if($response === true)
    {
        $ticket = new Ticket;
        $ticket->id_client = $client->id;
        $ticket->id_specialist = $_POST['specialist'];
        $response = $ticket->add();
        if($response === true)
            echo'
            <div class="alert alert-success" role="alert">
                Sveikiname! Sėkmingai užsiregistravote.
            </div>
            <div class="alert alert-info" role="alert">
                Nuoroda į kliento panelę <a href="./client.php?id='.openssl_encrypt($ticket->id, $ini['cipher'], $key, 0, $iv).'">čia</a>.
            </div>
            ';
        else
        {        
            if(!empty($response))
                echo'
                <div class="alert alert-danger" role="alert">
                    '.$response.'
                </div>
                ';
            else
                echo'
                <div class="alert alert-danger" role="alert">
                    Įvyko klaida, kreipkitės telefonu.
                </div>
                ';
        }
    }
    else
    {        
        if(!empty($response))
            echo'
            <div class="alert alert-danger" role="alert">
                '.$response.'
            </div>
            ';
        else
            echo'
            <div class="alert alert-danger" role="alert">
                Įvyko klaida, kreipkitės telefonu.
            </div>
            ';
    }
}
?>
<div class="container p-5">
    <form action="index.php" method="post">
        <div class="form-group">
            <input type="text" name="firstName" class="form-control text-center" placeholder="Vardas" required value="<?=(!empty($_POST['firstName'])?$_POST['firstName']:'')?>">
        </div>
        <div class="form-group">
            <input type="text" name="lastName" class="form-control text-center" placeholder="Pavardė" value="<?=(!empty($_POST['lastName'])?$_POST['lastName']:'')?>">
        </div>
        <div class="form-group">
            <select name="specialist" class="form-control">
                <option value="">Pasirink specialistą..</option>
            <?php
            foreach (Specialist::getSpecialists() as $specialist) {
            ?>
                <option value="<?=$specialist['id_specialist']?>"><?=$specialist['firstName']?> <?=$specialist['lastName']?></option>
            <?php
            }
            ?>
            </select>
        </div>
        <div class="form-group">
            <input type="submit" name="submitClient" class="form-control btn btn-outline-primary" value="Pateikti">
        </div>
    </form>
</div>