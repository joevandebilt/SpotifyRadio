<?php 
    require_once($_SERVER['DOCUMENT_ROOT']."/Classes/Class.Main.php");

    $DISession = new DISession();
    $DISession->DeleteSessionBySessionID(SessionID());

    session_destroy();

    header("Location: /");
    exit();
?>