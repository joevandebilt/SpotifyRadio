using System;
using System.Collections.Generic;
using System.Text;

namespace SpotifyRadio.Mobile.Models
{
    public class Request
    {
        public string Area { get; set; }
        public string Action { get; set; }
        public string SessionID { get; set; }
        public string RecpatchaToken { get; set; }
    }

    public class Request<T> : Request
    {
        public T Payload { get; set; }
    }
}
