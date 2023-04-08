<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<meta property="og:url"                content="<?php echo GetWebsiteURL(); ?>"/>
<meta property="og:type"               content="website" />

<?php
    if (empty($_GET['RoomCode']))
    {
        ?>
            <meta property="og:title"              content="nKode Spotify Radio" />
            <meta property="og:description"        content="Let anybody queue songs to your Spotify device" />
        <?php
    }
    else
    {

        $DISession = new DISession();
        $RoomSessionResponse= $DISession->GetSessionByRoomCode($_GET['RoomCode']);
		$RoomSession = $RoomSessionResponse->GetPayload();

        ?>

            <meta property="og:title"              content="Join <?php echo $RoomSession->RoomName; ?>'s nKode Spotify Radio" />
            <meta property="og:description"        content="Let anybody queue songs to your Spotify device" />

        <?php
    }
?>
<meta property="og:image"              content="https://storage.googleapis.com/pr-newsroom-wp/1/2018/11/folder_920_201707260845-1.png" />
