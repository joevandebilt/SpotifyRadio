using System;

namespace SpotifyRadio.Mobile.Models
{
    public class Response
    {
        public int StatusCode { get; set; }
        public string Message { get; set; }
    }

    public class Response<T> : Response
    {
        public T Payload { get; set; }
    }
}