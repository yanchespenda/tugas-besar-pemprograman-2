<?php
    defined('ISLOADPAGE') OR exit('No direct script access allowed');
    require_once __DIR__ . '/../extra/lib.php';

    use Josantonius\Session\Session;
    use \Carbon\Carbon;

    $isLoggin = false;
    $getToken = false;
    $getUsername = Session::get('username');
    $getUserId = Session::get('user_id');
    if ($getUserId) {
        $isLoggin = true;

        $getTokenTime = Session::get('jwt_expired');
        if ($getTokenTime->isBefore(Carbon::now())) {
            $getAdmin = Session::get('user_level');
            $getToken = generateCustomToken($getUserId, $getAdmin);
            Session::set('user_token', $getToken);
        } else {
            $getToken = Session::get('user_token');
        }

        // UPDATE tb_handphone SET merk = '{$getMerk}', tipe = '{$getTipe}', warna = '{$getWarna}', harga = '{$getHarga}' where id = $getId
    }
?>
<base href="/">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="msapplication-tap-highlight" content="no">
<link rel="icon" href="/favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link rel="dns-prefetch" href="//fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
<link rel="stylesheet" href="/app.css?<?php echo time(); ?>">

<?php
if ($getUserId):
    echo "<script>var userToken = '" . $getToken . "';</script>";
    echo "<script>var userID = " . $getUserId . ";</script>";
    echo "<script>var userName = '" . $getUsername . "';</script>";
endif;
?>
