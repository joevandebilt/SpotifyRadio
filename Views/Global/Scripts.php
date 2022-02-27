<!-- Bootstrap -->
<script src="<?php echo GetWebsiteURL(); ?>/Scripts/bootstrap.bundle.js"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

<!-- Recaptcha -->
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo Secrets::$RECAPTCHA_SITE_KEY; ?>" id="recaptchaScript"></script>

<script src="<?php echo GetWebsiteURL(); ?>/Scripts/site.js"></script>
<script src="<?php echo GetWebsiteURL(); ?>/Scripts/api-controls.js"></script>
<script src="<?php echo GetWebsiteURL(); ?>/Scripts/layout-controls.js"></script>
<script src="<?php echo GetWebsiteURL(); ?>/Scripts/admin-controls.js"></script>
<script src="<?php echo GetWebsiteURL(); ?>/Scripts/room-controls.js"></script>

<script type="text/javascript">
    localStorage.setItem("SessionID", "<?php echo SessionID(); ?>");
</script>