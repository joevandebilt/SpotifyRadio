using SpotifyRadio.Mobile.ViewModels;
using System.ComponentModel;
using Xamarin.Forms;

namespace SpotifyRadio.Mobile.Views
{
    public partial class ItemDetailPage : ContentPage
    {
        public ItemDetailPage()
        {
            InitializeComponent();
            BindingContext = new ItemDetailViewModel();
        }
    }
}