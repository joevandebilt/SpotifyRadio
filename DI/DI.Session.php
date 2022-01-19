<?php

    class DISession
    {
        function CreateSession($RoomCode)
        {
            $response = new Response();
            try
            {
                $sessionIdInUse = $this->GetSessionBySessionID(SessionID());
                $roomCodeInUse = $this->GetSessionByRoomCode($RoomCode);
                
                if ($sessionIdInUse->GetStatusCode() == 200)
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
                    $Query = "INSERT INTO Sessions (SessionID, AccessToken, RefreshToken, Expiry, ExpiryTime, RoomCode) VALUES (";
                    $Query .= "'',";
                    $Query .= "'',";
                    $Query .= "'',";
                    $Query .= "0,";
                    $Query .= "0,";
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

        function UpdateSession($AccessToken, $RefreshToken, $Expiry, $ExpiryTime, $RoomCode)
        {
            $response = new Response();
            try
            {
                $session = $this->GetSessionBySessionID()->GetPayload();
                if ($session != null)
                {
                    if ($AccessToken == null)  { $AccessToken = $session->GetAccessToken(); }
                    if ($RefreshToken == null) { $RefreshToken = $session->GetRefreshToken(); }
                    if ($Expiry == null)       { $Expiry = $session->GetExpiry(); }
                    if ($ExpiryTime == null)   { $ExpiryTime = $session->GetExpiryTime(); }
                    if ($RoomCode == null)     { $RoomCode = $session->GetRoomCode(); }

                    $DB = new MySql();
                    $Query = "UPDATE Sessions SET ";
                    $Query .= "AccessToken = '".addslashes($AccessToken)."', ";
                    $Query .= "RefreshToken = '".addslashes($RefreshToken)."', ";
                    $Query .= "Expiry = ".addslashes($Expiry).", ";
                    $Query .= "ExpiryTime = ".addslashes($ExpiryTime).", ";
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

        function DeleteSessionBySessionID()
        {
            $response = new Response();
            try
            {
                $DB = new MySql();
                $DB->query("DELETE FROM Sessions WHERE SessionID = '".SessionID()."'");

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
                        $List[$i] = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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
                        $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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

        function GetSessionBySessionID()
        {
            $response = new Response();
            try 
            {
                $DB = new MySql();
                $DB->query("SELECT * FROM Sessions WHERE SessionID = '".SessionID()."'");
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
                        $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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
                        $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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