<?php

class Response
{
    // --- PROPERTIES ---
    public $StatusCode = 0;
    public $Payload = null;
    public $Message= null;

    // --- CONSTRUCTOR ---
    public function __construct ($StatusCode = 0, $Payload = null, $Message = null)
    {
            $this->StatusCode = $StatusCode;
            $this->Payload = $Payload;
            $this->Message = $Message;
    }

    // GETTERS //
    public function GetStatusCode() {return $this->StatusCode;}
    public function GetPayload()    {return $this->Payload;}
    public function GetMessage()    {return $this->Message;}

    // SETTERS //
    public function SetStatusCode($val) { $this->StatusCode = $val;}
    public function SetPayload($val)    { $this->Payload = $val;}
    public function SetMessage($val)    { $this->Message = $val;}
}

?>
