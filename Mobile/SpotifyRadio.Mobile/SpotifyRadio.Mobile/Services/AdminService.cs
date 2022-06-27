using SpotifyRadio.Mobile.Models;
using SpotifyRadio.Mobile.Models.Admin;
using SpotifyRadio.Mobile.Services.Interfaces;
using System;
using System.Collections.Generic;
using System.Linq;
using System.Threading.Tasks;

namespace SpotifyRadio.Mobile.Services
{
    public class AdminService : IAdminService
    {
        public Response<RoomInfo> DisconnectSession(string SessionID)
        {
            throw new NotImplementedException();
        }

        public Response<RoomInfo> ExtendTimeout(string SessionID)
        {
            throw new NotImplementedException();
        }

        public Response<RoomInfo> GetRoomInfo(string SessionID)
        {
            throw new NotImplementedException();
        }

        public Response<RoomInfo> UpdateRoomCode(string SessionID, string RoomCode, string RoomName)
        {
            throw new NotImplementedException();
        }
    }
}