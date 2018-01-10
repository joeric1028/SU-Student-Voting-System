<?php
    $currentyear = strftime("%Y");
    if(isset($_POST['voteSubmit']))
    {
        $voteResult = mysqli_query($con, "UPDATE vote
        SET voted='Yes', year='{$currentyear}', governor='{$_POST['governor']}', vicegovernor='{$_POST['vicegovernor']}' 
        WHERE idvote='{$_SESSION['voterid']}';");
        if($voteResult == TRUE)$voteResult = "Record updated successfully";
        else $voteResult = "Error updating record: " . $con->error;
    }
?>