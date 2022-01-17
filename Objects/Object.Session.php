<?php

    class Session
    {
        // --- PROPERTIES ---
        public $ID = 0;
        public $SessionID = null;
        public $AccessToken = null;
        public $RefreshToken = null;
        public $Expiry = 0;
        public $ExpiryTime = 0;
        public $RoomCode = null;

        // --- CONSTRUCTOR ---
        public function __construct ($ID = 0, $SessionID = null, $AccessToken = null, $RefreshToken = null, $Expiry = 0, $ExpiryTime = 0, $RoomCode = null)
        {
                $this->ID = $ID;
                $this->SessionID = $SessionID;
                $this->AccessToken = $AccessToken;
                $this->RefreshToken = $RefreshToken;
                $this->Expiry = $Expiry;
                $this->ExpiryTime = $ExpiryTime;
                $this->RoomCode = $RoomCode;
        }

        // GETTERS //
        public function GetID()             {return $this->ID;}
        public function GetSessionID()      {return $this->SessionID;}
        public function GetAccessToken()    {return $this->AccessToken;}
        public function GetRefreshToken()   {return $this->RefreshToken;}
        public function GetExpiry()         {return $this->Expiry;}
        public function GetExpiryTime()     {return $this->ExpiryTime;}
        public function GetRoomCode()       {return $this->RoomCode;}

        // SETTERS //
        public function SetID($val)             { $this->ID = $val;}
        public function SetSessionID($val)      { $this->SessionID = $val;}
        public function SetAccessToken($val)    { $this->AccessToken = $val;}
        public function SetRefreshToken($val)   { $this->RefreshToken = $val;}
        public function SetExpiry($val)         { $this->Expiry = $val;}
        public function SetExpiryTime($val)     { $this->ExpiryTime = $val;}
        public function SetRoomCode($val)       { $this->RoomCode = $val;}
    }

?>