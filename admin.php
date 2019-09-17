<?php

$title = "Specialisto panelė";
include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';

if(!empty($_POST['clientComplete']))
{
    $client = new Client($_POST['id_client']);
    if($client->complete())
    {

    }
}

$Clients = Client::getClients();

?>

<div class="container p-5">
    <ul class="list-group">
        <?php foreach ($Clients as $key => $client) { ?>
            <?='
            <li class="list-group-item '.($key == 0? 'active':'').'">
                '.$client['firstName'].(!empty($client['firstName'])?' '.$client['lastName']:'').'
                '.($key == 0? '
                <form action="admin.php" method="post" class="float-right ml-3">
                    <input type="hidden" name="id_client" value="'.$client['id_client'].'">
                    <input type="submit" name="clientComplete" class="btn btn-danger btn-sm" value="&times;">
                </form>
                ':'').'
                <span class="float-right">
                    '.$client['meetingTime'].'
                </span>
            </li>
            '?>
        
        <?php } ?>
    </ul>
</div>