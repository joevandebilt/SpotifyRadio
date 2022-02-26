<?php

    class DISession
    {
        function CreateSession($SessionID, $RoomName, $RoomCode)
        {
            $response = new Response();
            try
            {
                $SessionIDInUse = $this->GetSessionBySessionID($SessionID);
                $roomCodeInUse = $this->GetSessionByRoomCode($RoomCode);
                
                if ($SessionIDInUse->GetStatusCode() == 200)
                {
                    $response->SetStatusCode(400);
                    $response->SetMessage("Room Exists for Session - cannot create new");
                }
                else if ($roomCodeInUse->GetStatusCode() == 200)
                {
                    $response->SetStatusCode(400);
                    $response->SetMessage("Room Code in use");
                }
                else 
                {
                    $DB = new MySql();
                    $Query = "INSERT INTO Sessions (SessionID, AccessToken, RefreshToken, Expiry, ExpiryTime, RoomName, RoomCode) VALUES (";
                    $Query .= "'".addslashes($SessionID)."',";
                    $Query .= "'',";
                    $Query .= "'',";
                    $Query .= "7200,";
                    $Query .= (time()+7200.).",";  //Give new users 2 hours to connect Spotify
                    $Query .= "'".addslashes($RoomName)."',";
                    $Query .= "'".addslashes($RoomCode)."')";

                    $DB->query($Query);
                    if ($DB->hasErrors())
                    {
                        $response->SetStatusCode(500);
                        $response->SetMessage($DB->showErrors());
                    }
                    else 
                    {
                        $id = $DB->fetchLastInsertId();
                        if ($id != null && $id >= 0)
                        {
                            $response->SetPayload($this->GetSessionByID($id)->GetPayload());
                            $response->SetStatusCode(200);
                        }
                        else 
                        {
                            $response->SetStatusCode(400);
                            $response->SetMessage("Failed to Create Session");
                        }
                    }
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function UpdateSession($SessionID, $AccessToken, $RefreshToken, $Expiry, $ExpiryTime, $RoomName, $RoomCode)
        {
            $response = new Response();
            try
            {
                $session = $this->GetSessionBySessionID($SessionID)->GetPayload();
                if ($session != null)
                {
                    if (is_null($AccessToken))  { $AccessToken = $session->GetAccessToken(); }
                    if (is_null($RefreshToken)) { $RefreshToken = $session->GetRefreshToken(); }
                    if (is_null($Expiry))       { $Expiry = $session->GetExpiry(); }
                    if (is_null($ExpiryTime))   { $ExpiryTime = $session->GetExpiryTime(); }
                    if (is_null($RoomName))     { $RoomName = $session->GetRoomName(); }
                    if (is_null($RoomCode))     { $RoomCode = $session->GetRoomCode(); }

                    $DB = new MySql();
                    $Query = "UPDATE Sessions SET ";
                    $Query .= "AccessToken = '".addslashes($AccessToken)."', ";
                    $Query .= "RefreshToken = '".addslashes($RefreshToken)."', ";
                    $Query .= "Expiry = ".addslashes($Expiry).", ";
                    $Query .= "ExpiryTime = ".addslashes($ExpiryTime).", ";
                    $Query .= "RoomName = '".addslashes($RoomName)."', ";
                    $Query .= "RoomCode = '".addslashes($RoomCode)."' ";
                    $Query .= "WHERE ID = ".$session->GetID();

                    $DB->query($Query);

                    if ($DB->hasErrors())
                    {
                        $response->SetStatusCode(500);
                        $response->SetMessage($DB->showErrors());
                    }
                    else 
                    {
                        $sessionObj = $this->GetSessionByID($session->ID);
                        $response->SetPayload($sessionObj->GetPayload());
                        $response->SetStatusCode($sessionObj->GetStatusCode());
                    }
                }
                else 
                {
                    $response->SetStatusCode(400);
                    $response->SetMessage("Failed to Find Existing Session");
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function DeleteSessionBySessionID($SessionID)
        {
            $response = new Response();
            try
            {
                $DB = new MySql();
                $DB->query("DELETE FROM Sessions WHERE SessionID = '".$SessionID."'");

                if ($DB->hasErrors())
                {
                    $response->SetStatusCode(500);
                    $response->SetMessage($DB->showErrors());
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function DeleteExpiredSessions()
        {
            $response = new Response();
            try
            {
                $time = time();
                $DB = new MySql();
                $DB->query("DELETE FROM Sessions WHERE ExpiryTime < ".$time." AND ExpiryTime > 0");

                if ($DB->hasErrors())
                {
                    $response->SetStatusCode(500);
                    $response->SetMessage($DB->showErrors());
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function GetAllSessions()
        {
            $response = new Response();
            try 
            {
                $DB = new MySql();
                $List = array();
                $DB->query("SELECT * FROM Sessions");
                if ($DB->hasErrors())
                {
                    $response->SetStatusCode(500);
                    $response->SetMessage($DB->showErrors());
                }
                else 
                {
                    $i=0;
                    $Status = 204;
                    while ($row = $DB->fetchObject())
                    {
                        $List[$i] = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomName, $row->RoomCode);
                        $Status = 200;
                        $i++;                        
                    }
                    $response->SetPayload($List);
                    $response->SetStatusCode($Status);
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function GetSessionByID($ID)
        {
            $response = new Response();
            try 
            {
                $DB = new MySql();
                $DB->query("SELECT * FROM Sessions WHERE ID =".$ID);
                if ($DB->hasErrors())
                {
                    $response->SetStatusCode(500);
                    $response->SetMessage($DB->showErrors());
                }
                else 
                {
                    $Model = null;
                    $Status = 204;
                    while ($row = $DB->fetchObject())
                    {
                        $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomName, $row->RoomCode);
                        $Status = 200;
                    }
                    $response->SetPayload($Model);
                    $response->SetStatusCode($Status);
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function GetSessionBySessionID($SessionID)
        {
            $response = new Response();
            try 
            {
                $DB = new MySql();
                $DB->query("SELECT * FROM Sessions WHERE SessionID = '".$SessionID."'");
                if ($DB->hasErrors())
                {
                    $response->SetStatusCode(500);
                    $response->SetMessage($DB->showErrors());
                }
                else 
                {
                    $Model = null;
                    $Status = 204;
                    while ($row = $DB->fetchObject())
                    {
                        $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomName, $row->RoomCode);
                        $Status = 200;
                    }
                    $response->SetPayload($Model);
                    $response->SetStatusCode($Status);
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }

        function GetSessionByRoomCode($RoomCode)
        {
            $response = new Response();
            try 
            {
                $DB = new MySql();
                $Query = "SELECT * FROM Sessions WHERE RoomCode = '".$RoomCode."'";
                $DB->query($Query);
                if ($DB->hasErrors())
                {
                    $response->SetStatusCode(500);
                    $response->SetMessage($DB->showErrors());
                }
                else 
                {
                    $Model = null;
                    $Status = 204;
                    while ($row = $DB->fetchObject())
                    {
                        $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomName, $row->RoomCode);
                        $Status = 200;
                    }
                    $response->SetPayload($Model);
                    $response->SetStatusCode($Status);
                }
            }
            catch (Exception $e) 
            {
                $response->SetStatusCode(500);
                $response->SetMessage('Caught exception: ',  $e->getMessage());
            }
            return $response;
        }
    }

?>