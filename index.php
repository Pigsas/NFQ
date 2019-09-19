<?php

include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';

if(!empty($_POST['submitClient']))
{
    $client = new Client;
    $client->firstName = $_POST['firstName'];
    $client->lastName = $_POST['lastName'];

    if($client->add())
    {
        $ticket = new Ticket;
        $ticket->id_client = $client->id;
        if($ticket->add())
            echo'
            <div class="alert alert-success" role="alert">
                Sveikiname! Sėkmingai užsiregistravote.
            </div>
            <div class="alert alert-info" role="alert">
                Nuoroda į kliento panelę <a href="./client.php?id='.$client->id.'">čia</a>.
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
            <input type="text" name="firstName" class="form-control text-center" placeholder="Vardas" required>
        </div>
        <div class="form-group">
            <input type="text" name="lastName" class="form-control text-center" placeholder="Pavardė">
        </div>
        <div class="form-group">
            <input type="submit" name="submitClient" class="form-control btn btn-outline-primary" value="Pateikti">
        </div>
    </form>
</div>