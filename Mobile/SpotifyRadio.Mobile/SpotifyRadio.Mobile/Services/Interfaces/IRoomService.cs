using System;
using System.Collections.Generic;
using System.Text;

namespace SpotifyRadio.Mobile.Services.Interfaces
{
    public interface IRoomService
    {
        object RoomReady(string RoomCode);
        object GetUserInfo(string RoomCode);
        object GetCurrentTrack(string RoomCode);
        object GetTrackInfo (string RoomCode, string TrackUri);
        object QueueTrack(string RoomCode, string TrackUri);
        object Search(string RoomCode, string SearchText);
    }
}
