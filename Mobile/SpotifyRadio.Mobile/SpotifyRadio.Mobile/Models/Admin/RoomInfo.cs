using System;
using System.Collections.Generic;
using System.Text;

namespace SpotifyRadio.Mobile.Models.Admin
{
    public class RoomInfo
    {
        public string ID { get; set; }
        public string SessionID { get; set; }
        public string AccessToken { get; set; }
        public string RefreshToken { get; set; }
        public string Expiry { get; set; }
        public string ExpiryTime { get; set; }
        public string RoomName { get; set; }
        public string RoomCode { get; set; }
    }
}
