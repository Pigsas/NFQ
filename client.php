<?php

$title = "Kliento puslapis";
include 'view/templates/header.php';
include 'includes/autoloader.php';
include 'database.php';


if(empty($_GET['id']))
{
    header('location: index.php');
}
$ticket = new Ticket($_GET['id']);
if(!empty($ticket->meetingEnds))
    $message = "JŪSŲ APSILANKYMAS JAU BAIGĖSI !";
elseif(!empty($ticket->meetingTime))
    $message = "JŪSŲ APSILANKYMAS VYSTA DABAR !";
else
{
    $eile = array_search($_GET['id'], array_column(Ticket::getTickets($ticket->id_specialist), 'id_ticket'));
    $eile++;
    $message = "IKI APSILANKYMO LIKO:<b> ".date('H:i', mktime(0,$eile*$ticket->averageTime()))."</b> min.";
}
    
?>
<div class="container p-5">
    <ul class="list-group text-center">
        <li class="list-group-item"><?=$message?></li>
    </ul>
</div>