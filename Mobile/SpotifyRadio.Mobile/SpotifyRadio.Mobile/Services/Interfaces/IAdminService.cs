using SpotifyRadio.Mobile.Models;
using SpotifyRadio.Mobile.Models.Admin;
using System;
using System.Collections.Generic;
using System.Text;

namespace SpotifyRadio.Mobile.Services.Interfaces
{
    public interface IAdminService
    {
        Response<RoomInfo> GetRoomInfo(string SessionID);
        Response<RoomInfo> UpdateRoomCode(string SessionID, string RoomCode, string RoomName);
        Response<RoomInfo> ExtendTimeout (string SessionID);
        Response<RoomInfo> DisconnectSession (string SessionID);
    }
}
