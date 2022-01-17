<?php

    class DISession
    {
        function CreateSession($AccessToken, $RefreshRoken, $Expiry, $ExpiryTime, $RoomCode)
        {
            $response = new Response();
            try
            {
                $sessionIdInUse = $this->GetSessionBySessionID(SessionID());
                $roomCodeInUse = $this->GetSessionByRoomCode($RoomCode);
                
                if ($sessionIdInUse != null)
                {
                    $response->SetStatusCode(400);
                    $response->SetMessage("Room Exists for Session - cannot create new");
                }
                else if ($roomCodeInUse != null)
                {
                    $response->SetStatusCode(400);
                    $response->SetMessage("Room Code in use");
                }
                else 
                {
                    $DB = new MySql();
                    $Query = "INSERT INTO Sessions (SessionID, AccessToken, RefreshToken, Expiry, ExpiryTime, RoomCode) VALUES (";
                    $Query .= "'".addslashes(SessionID())."',";
                    $Query .= "'".addslashes($AccessToken)."',";
                    $Query .= "'".addslashes($RefreshRoken)."',";
                    $Query .= addslashes($Expiry).",";
                    $Query .= addslashes($ExpiryTime).",";
                    $Query .= "'".addslashes($RoomCode)."')";

                    $DB->query($Query);

                    $id = -1;
                    $model = null;
                    if ($DB->fetchLastInsertId() > 0)
                    {
                        $id = $DB->fetchLastInsertId();
                        $response->SetPayload($this->GetSessionByID($id));
                        $response->SetStatusCode(200);
                    }
                    else 
                    {
                        $response->SetStatusCode(400);
                        $response->SetMessage("Failed to Create Session");
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

        function DeleteSessionBySessionID()
        {
            $response = new Response();
            try
            {
                $DB = new MySql();
                $DB->query("DELETE FROM Sessions WHERE SessionID = '".SessionID()."'");
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
                $i=0;
                while ($row = $DB->fetchObject())
                {
                    $List[$i] = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
                    $i++;
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
                $Model = null;
                while ($row = $DB->fetchObject())
                {
                    $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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
                $Model = null;
                while ($row = $DB->fetchObject())
                {
                    $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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
                $DB->query("SELECT * FROM Sessions WHERE RoomCode = '".$RoomCode."'");
                $Model = null;
                while ($row = $DB->fetchObject())
                {
                    $Model = new Session($row->ID, $row->SessionID, $row->AccessToken, $row->RefreshToken, $row->Expiry, $row->ExpiryTime, $row->RoomCode);
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