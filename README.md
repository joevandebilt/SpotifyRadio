# SpotifyRadio
A radio project to share Spotify in the office like a collaborative radio. Connect your account, share your room and let others queue songs to your active device 

## Access it live [here](https://spotify.nkode.uk)

### Room Administration
In order to create a room you need to create a room or click the Admin link in the header, then in your room authenticate with Spotify. 

    > To connect your Spotify account must be on a premium subscription

You can edit your room name, which is purely descriptive - and you can edit your room code. Initially room codes are randomly generated, but can be adjusted to any 8 letter code. 

When signed in the auth token will last 1 hour unless extended with the "Extend Expiry" button. 

"Disconnect from Spotify" will clear your token from the room. Even if people are still in your room they can no longer queue songs to your device. 

"Clear all data" destroys your room and session cookie - clearing all you data and returning you to the home page. 

The share tab provides a QR code and hyperlink for anybody wishing to join your room. 

The Debug tab provides debug information 

### Room
Join a room with either a Room code or QR code. When in a room you can queue a song by entering the track link into the textbox and pressing Queue. If the room is not ready, or the host is disconnected from Spotify the queue button will not be enabled. 

    > You do not need Spotify premium to queue songs