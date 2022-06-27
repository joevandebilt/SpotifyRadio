using SpotifyRadio.Mobile.Models;
using SpotifyRadio.Mobile.ViewModels;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using Xamarin.Forms;
using Xamarin.Forms.Xaml;

namespace SpotifyRadio.Mobile.Views
{
    public partial class NewItemPage : ContentPage
    {
        public Response Item { get; set; }

        public NewItemPage()
        {
            InitializeComponent();
            BindingContext = new NewItemViewModel();
        }
    }
}