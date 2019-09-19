<?php

$title = "Kliento puslapis";
include 'includes/autoloader.php';
include 'database.php';

if(!empty($_GET['id']) && !empty($_GET['action']))
{
    if($_GET['action'] == "getTime")
    {
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
        die($message);
    }
}

include 'view/templates/header.php';


if(empty($_GET['id']))
{
    header('location: index.php');
}
    
?>
<div class="container p-5" onload="getMessage()">
    <ul class="list-group text-center">
        <li class="list-group-item" id="message"></li>
    </ul>
</div>

<script>
    function getMessage()
    {
        var ajax = new XMLHttpRequest();
        ajax.open("GET", "./client.php?id=<?=$_GET['id']?>&action=getTime", true);
        ajax.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('message').innerHTML = ajax.responseText;
            }
        };
        ajax.send();
    }
    getMessage()
    window.setInterval(function(){
        getMessage()
    }, 5000);
</script>