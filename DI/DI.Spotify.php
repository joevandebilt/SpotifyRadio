<?php
    class DISpotify
    {
        function GetClientID()
        {
            return "046f25af5f1444a881c64cec8ec3f716";
        }

        function GetClientSecret()
        {
            return file_get_contents($_SERVER['DOCUMENT_ROOT']."/client_secret", true);
        }
    }
?>