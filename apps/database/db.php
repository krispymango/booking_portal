<?php
session_start();
date_default_timezone_set('Africa/Accra');



               /* signup database connection */



function Signup()
{
global $conn;

       /* stripcslashes */
$phone_no = stripcslashes($_POST['phone_no']);
$username = stripcslashes($_POST['user_name']);
$pswd = stripcslashes($_POST['password']);
$pswd_conf = stripcslashes($_POST['password_conf']);
$emal = stripcslashes($_POST['email']);
$dayy = stripcslashes($_POST['day']);
$monthh = stripcslashes($_POST['month']);
$yearr = stripcslashes($_POST['year']);
$date_o_birth = stripcslashes($dayy ."-". $monthh ."-". $yearr);
$user_ip = $_SERVER['REMOTE_ADDR'];
$curr_on_date = date('Y-m-d');
$curr_on_time = date('h-i-s');
       /* stripcslashes */



       /* mysqli real escape string(prevent sql injection) */
$phone_no = mysqli_real_escape_string($conn,$phone_no);
$username = mysqli_real_escape_string($conn,$username);
$pswd = mysqli_real_escape_string($conn,$pswd);
$pswd_conf = mysqli_real_escape_string($conn,$pswd_conf);
$emal = mysqli_real_escape_string($conn,$emal);
$dayy = mysqli_real_escape_string($conn,$dayy);
$monthh = mysqli_real_escape_string($conn,$monthh);
$yearr = mysqli_real_escape_string($conn,$yearr);
$date_o_birth = mysqli_real_escape_string($conn,$date_o_birth);
$user_ip = mysqli_real_escape_string($conn,$user_ip);
$curr_on_date =  mysqli_real_escape_string($conn,$curr_on_date);
$curr_on_time =  mysqli_real_escape_string($conn,$curr_on_time);
       /* mysqli real escape string(prevent sql injection) */


$existing_user = ValidateSignup();

if ($pswd != $pswd_conf)
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "passwords do not match";
}

elseif (($dayy == 'day') || ($monthh == 'month') || ($yearr == 'year'))
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "please fill the date of birth";
}

elseif (strlen($phone_no) < 10)
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "phone no. less than 10 characters";
}

elseif (strlen($username) > 25)
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "username is more than 25 characters";
}

elseif ($existing_user == 1)
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "User Already exist";
}

else
{
  echo " ";
  $hashedPassword = password_hash($pswd,PASSWORD_DEFAULT);
  $sgn_sql = "INSERT INTO user_info(phone_number,password,email,dob,username,user_ip,current_date_online,current_time_online) VALUES('$phone_no','$hashedPassword','$emal','$date_o_birth','$username','$user_ip','$curr_on_date','$curr_on_time')";
  $sgn_sql_execute = mysqli_query($conn,$sgn_sql);
  CreatePlayers();

  if ($sgn_sql_execute)
  {
    echo "
    <script>
    $('.loading_modal_wrapper').hide();
    </script>
    ";
    LoginSignup();
    sleep(1);
    echo "<script>
    $(document).ready(function() {
    $('.signup_modal').hide();
    });</script>";
    $_SESSION['user'] = 'logged';
    echo "<script> window.location.reload()</script>";
  }
  else
  {
    echo "**Error Could not Signup**";
  }
}

}


function CreatePlayers()
{
  global $conn;
  $phone_no = stripcslashes($_POST['phone_no']);
  $phone_no = mysqli_real_escape_string($conn,$phone_no);

  $lgn_sgn_sql_select = "SELECT * FROM user_info where phone_number = '$phone_no'";
  $lgn_sgn_sql_execute_select = mysqli_query($conn,$lgn_sgn_sql_select);
  $lgn_sgn_sql_fetch_select = mysqli_fetch_assoc($lgn_sgn_sql_execute_select);

  $usr_id = $lgn_sgn_sql_fetch_select['user_id'];

// random list of values
$player_no = array();
for ($i=1; $i<=300 ;$i++)
    {
        $player_no[$i] = $i;
        echo $player_no[$i];
        echo"<br/>";
    }
  //$player_no = array('1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20');
  $player_names = array('azriel','todd','ben','james','ben','frederick','oscar','tobi','james','francis','lopez','jamal','kareem','dave');


//random 5 player names
  $random_playr_name_one = $player_names[array_rand($player_names,1)];
  $random_playr_name_two = $player_names[array_rand($player_names,1)];
  $random_playr_name_three = $player_names[array_rand($player_names,1)];

//random 5 player numbers
  $random_playr_no_one = $player_no[array_rand($player_no,1)];
  $random_playr_no_two = $player_no[array_rand($player_no,1)];
  $random_playr_no_three = $player_no[array_rand($player_no,1)];

  $sql_insrt_plyr = "INSERT INTO player_info(player_no,player_name,user_id)
  VALUES('$random_playr_no_one','$random_playr_name_one','$usr_id'),
  ('$random_playr_no_two','$random_playr_name_two','$usr_id'),
  ('$random_playr_no_three','$random_playr_name_three','$usr_id')";
  $sql_exec_insrt_plyr = mysqli_query($conn,$sql_insrt_plyr);
}


function ValidateSignup()
{
global $conn;
$phone_no = stripcslashes($_POST['phone_no']);
$phone_no = mysqli_real_escape_string($conn,$phone_no);
$username = stripcslashes($_POST['user_name']);
$username = mysqli_real_escape_string($conn,$username);
//echo $phone_no;
$sgn_sql_select = "SELECT * FROM user_info WHERE phone_number = '$phone_no'";
$sgn_sql_execute_select = mysqli_query($conn,$sgn_sql_select);
$sgn_sql_fetch_select = mysqli_fetch_assoc($sgn_sql_execute_select);
$sgn_num_rows = mysqli_num_rows($sgn_sql_execute_select);
return $sgn_num_rows;
}

function LoginSignup()
{
global $conn;
$phone_no = stripcslashes($_POST['phone_no']);
$phone_no = mysqli_real_escape_string($conn,$phone_no);
//echo $phone_no;
$lgn_sgn_sql_select = "SELECT * FROM user_info where phone_number = '$phone_no'";
$lgn_sgn_sql_execute_select = mysqli_query($conn,$lgn_sgn_sql_select);
$lgn_sgn_sql_fetch_select = mysqli_fetch_assoc($lgn_sgn_sql_execute_select);

$_SESSION['id'] = $lgn_sgn_sql_fetch_select['user_id'];
$_SESSION['phone'] = $lgn_sgn_sql_fetch_select['phone_number'];
$_SESSION['username'] = $lgn_sgn_sql_fetch_select['username'];
$_SESSION['email'] = $lgn_sgn_sql_fetch_select['email'];
$_SESSION['dob'] = $lgn_sgn_sql_fetch_select['dob'];
$_SESSION['amount'] = $lgn_sgn_sql_fetch_select['points'];
}



              /* signup database connection */











               /* login database connection */

function Login()
{
global $conn;
$login_email = stripcslashes($_POST['email']);
$login_email = mysqli_real_escape_string($conn,$login_email);
$login_pswd = stripcslashes($_POST['password']);
$login_pswd = mysqli_real_escape_string($conn,$login_pswd);

$lgn_sql = "SELECT * FROM user_info WHERE email = '$login_email'";
$lgn_sql_execute = mysqli_query($conn,$lgn_sql);
$lgn_sql_fetch = mysqli_fetch_assoc($lgn_sql_execute);
$curr_date = date('Y-m-d');
$curr_time = date('h-i-s');

if($lgn_sql_execute)
  {
   if (($lgn_sql_fetch) && (password_verify($login_pswd,$lgn_sql_fetch['password'])))
   {
     $sql_lgn_status = "UPDATE user_info SET status='1', current_date_online='$curr_date', current_time_online='$curr_time' WHERE email='$login_email'";
     $sql_execute_lgn_status = mysqli_query($conn,$sql_lgn_status);
     $_SESSION['id'] = $lgn_sql_fetch['user_id'];
     $_SESSION['username'] = $lgn_sql_fetch['username'];
     $_SESSION['email'] = $lgn_sql_fetch['email'];
     $_SESSION['dob'] = $lgn_sql_fetch['dob'];
     $_SESSION['amount'] = $lgn_sql_fetch['points'];
     echo "<script>
     $(document).ready(function() {
     $('.signup_modal').hide();
     });</script>";
     $_SESSION['user'] = 'logged';
     echo "<script> window.location.reload()</script>";
    }
    else
    {
      echo "
      <script>
      $('.loading_modal_wrapper').hide();
      </script>
      ";
      echo "email and password are incorrect";
    }
  }

    else
    {
      echo "
      <script>
      $('.loading_modal_wrapper').hide();
      </script>
      ";
      echo "**error Login in User**";
    }

}


                                /* login database connection */










                                /* logout database connection */

function Logout()
{
  global $conn;
  $curr_date_offline = date('Y-m-d');
  $curr_time_offline = date('h-i-s');
  $sql_status = "UPDATE user_info SET status=0, current_time_offline='$curr_time_offline',current_date_offline='$curr_date_offline' WHERE phone_number='$_SESSION[phone]'";
  $sql_execute_status = mysqli_query($conn,$sql_status);

    if ($sql_execute_status )
    {
      unset($_SESSION['user']);
      unset($_SESSION['username']);
      unset($_SESSION['phone']);
      unset($_SESSION['email']);
      unset($_SESSION['id']);
      unset($_SESSION['notif_id']);
      unset($_SESSION['dob']);
      unset($_SESSION['counter']);
      unset($_SESSION['amount']);
      //unset();
      //unset();
      //unset();
      session_destroy();
      include 'assets/helpers/user_authentication.php';
    }
    else
    {
      echo "<script>
      $(document).alert('error could not log out');
      </script>";
    }

}



                                /* logout database connection */
















                                /* Lan match connection */
function LanMatch()
{
  global $conn;
  $rcp_id = stripcslashes($_POST['recepient_id']);
  $rcp_id = mysqli_real_escape_string($conn,$rcp_id);
  $sender_amnt = stripcslashes($_POST['strt_amount']);
  $sender_amnt = mysqli_real_escape_string($conn,$sender_amnt);
  if ($sender_amnt >= 5)
  {
    if ($_SESSION['amount'] < $sender_amnt )
    {
      echo "<script>
      $(document).ready(function()
      {
        $('.qr_modal_wrapper').show();
      });
      </script>";
      echo
      "
      <i class='fas fa-3x fa-frown'></i>
      <h3>You dont have the required amount to start</h3>";
    }
    else
    {
    $QR_TEXT = "".$rcp_id."";
    $file_name = 'trade_qr.png';
    QRcode::png($QR_TEXT  , $file_name,'M', 4, 2);
    echo "<script>
    $(document).ready(function()
    {
      $('.qr_modal_wrapper').show();
    });
    </script>";
    echo
    "
    <h3>Scan Qr Code</h3>
    <img class='match_start_qr_code' src='assets/helpers/trade_qr.png'>
    ";
  }

  }

  else
  {
    echo "<script>
    $(document).ready(function()
    {
      $('.qr_modal_wrapper').show();
    });
    </script>";
    echo
    "
    <i class='fas fa-3x fa-frown'></i>
    <h4>You dont have the required amount to start</h4>
    ";
  }

}


















                                /* Lan Trade database connection */

function LanRecieveTrade()
{
  global $conn;
  $rcv_plyr = stripcslashes($_POST['player_r_trade']);
  $rcv_plyr = mysqli_real_escape_string($conn,$rcv_plyr);

  $rcv_amount = stripcslashes($_POST['trade_amount']);
  $rcv_amount = mysqli_real_escape_string($conn,$rcv_amount);

  $rcv_id = stripcslashes($_POST['receiver_id']);
  $rcv_id = mysqli_real_escape_string($conn,$rcv_id);

  $rcv_code = stripcslashes($_POST['verify_sender_code']);
  $rcv_code = mysqli_real_escape_string($conn,$rcv_code);
//  $scanner_sender_id = $_POST['snder'];

if (empty($_SESSION['amount']) || empty($rcv_amount) || empty($rcv_id) || empty($rcv_code) || empty($rcv_plyr))
{
  echo "<script>
  $(document).ready(function()
  {
    $('.qr_modal_wrapper').show();
  });
  </script>";
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo
  "
  <i class='fas fa-3x fa-frown'></i>
  <h3>Please fill in Details</h3>";
}
elseif($_SESSION['amount'] < $rcv_amount)
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "<script>
  $(document).ready(function()
  {
    $('.qr_modal_wrapper').show();
  });
  </script>";
  echo
  "
  <i class='fas fa-3x fa-frown'></i>
  <h3>You dont have the required amount to trade</h3>";
}
else
{
  echo "<script>
  $(document).ready(function()
  {
    $('.scanner_modal_wrapper').show();
  });
  </script>";
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "
  <form class='qr_scanner_form' action='process.html' method='post'>
  <input type='hidden' id='r_id' name='rcvv_id' value='".$rcv_id."'>
  <input type='hidden' id='r_amount' name='rcvv_amount' value='".$rcv_amount."'>
  <input type='hidden' id='r_plyr' name='rcvv_plyr' value='".$rcv_plyr."'>
  <input type='hidden' id='r_code' name='rcvv_code' value='".$rcv_code."'>
  <input type='hidden' id='s_id' name='sndr_info'>
  </form>
  ";

  echo "
  <script>
  $(document).ready(function()
  {
  $('.qr_scanner_form').submit(function(event){
  event.preventDefault();
  var rcvv_id = $('#r_id').val();
  var rcvv_amount = $('#r_amount').val();
  var rcvv_plyr = $('#r_plyr').val();
  var rcvv_code = $('#r_code').val();
  var sndr_info = $('#s_id').val();
  $('#qr-reader').load('assets/helpers/verify_trade',
  {
    rcvv_id: rcvv_id,
    rcvv_amount: rcvv_amount,
    rcvv_plyr: rcvv_plyr,
    rcvv_code: rcvv_code,
    sndr_info: sndr_info
  });
  });
  });
  </script>";
}

//echo "<input type='text' name='' value='".$sndr_id."'>";
//echo $_POST['receiver_id'];
  //if ((isset($scanner_sender_id)) && (isset($rcv_id)))
  //{
  //  // code...
  //}
}


function LanSendTrade()
{
  global $conn;
  $snd_id = stripcslashes($_POST['sender_id']);
  $snd_id = mysqli_real_escape_string($conn,$snd_id);
  $sender_amnt = stripcslashes($_POST['expected_amount']);
  $sender_amnt = mysqli_real_escape_string($conn,$sender_amnt);
  $snd_player_to_trade = stripcslashes($_POST['player_to_trade']);
  $snd_player_to_trade = mysqli_real_escape_string($conn,$snd_player_to_trade);
  $snd_code = stripcslashes($_POST['sender_code']);
  $snd_code = mysqli_real_escape_string($conn,$snd_code);
  $simple_string = "Id=".$snd_id.",Amount=".$sender_amnt.",PlayerID=".$snd_player_to_trade."";
// Display the original string
//echo "Original String: " . $simple_string;
// Store the cipher method
$ciphering = "AES-128-CTR";
// Use OpenSSl Encryption method
$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
// Non-NULL Initialization Vector for encryption
$encryption_iv = '1234567891011121';
// Store the encryption key
$encryption_key = $snd_code;
// Use openssl_encrypt() function to encrypt the data
$encryption = openssl_encrypt($simple_string, $ciphering,
$encryption_key, $options, $encryption_iv);
  if ($sender_amnt >= 5)
  {
    if (empty($snd_code))
    {
      echo "<script>
      $(document).ready(function()
      {
        $('.qr_modal_wrapper').show();
      });
      </script>";
      echo "
      <script>
      $('.loading_modal_wrapper').hide();
      </script>
      ";
      echo
      "
      <i class='fas fa-3x fa-frown'></i>
      <h3>Please fill in Trade Code</h3>";
    }
    else
    {
    $QR_TEXT = $encryption;
    $file_name = 'trade_qr.png';
    QRcode::png($QR_TEXT  , $file_name,'M', 4, 2);
    echo "<script>
    $(document).ready(function()
    {
      $('.qr_modal_wrapper').show();
    });
    </script>";
    echo "
    <script>
    $('.loading_modal_wrapper').hide();
    </script>
    ";
    echo
    "
    <h3>Scan Qr Code</h3>
    <img class='match_start_qr_code' src='assets/helpers/trade_qr.png'>
    ";
  }

  }

  else
  {
    echo "<script>
    $(document).ready(function()
    {
      $('.qr_modal_wrapper').show();
    });
    </script>";
    echo "
    <script>
    $('.loading_modal_wrapper').hide();
    </script>
    ";
    echo
    "
    <i class='fas fa-3x fa-frown'></i>
    <h4>You dont have the required amount to Trade</h4>
    ";
  }

}



function TradeExecute()
{
global $conn;
// reciever info
$id_of_receiver = stripcslashes($_POST['rcvv_id']);
$id_of_receiver = mysqli_real_escape_string($conn,$id_of_receiver);
$amount_of_receiver = stripcslashes($_POST['rcvv_amount']);
$amount_of_receiver = mysqli_real_escape_string($conn,$amount_of_receiver);
$player_to_receive_id = stripcslashes($_POST['rcvv_plyr']);
$player_to_receive_id = mysqli_real_escape_string($conn,$player_to_receive_id);
$reciever_code = stripcslashes($_POST['rcvv_code']);
$reciever_code = mysqli_real_escape_string($conn,$reciever_code);
// sender info
$ciphering = "AES-128-CTR";
// Use OpenSSl Encryption method
//$iv_length = openssl_cipher_iv_length($ciphering);
$options = 0;
// Non-NULL Initialization Vector
$encryption = stripcslashes($_POST['sndr_info']);
$encryption = mysqli_real_escape_string($conn,$encryption);
$decryption_iv = '1234567891011121';
// Store the decryption key
$decryption_key = $reciever_code;
// Use openssl_decrypt() function to decrypt the data
$decryption = openssl_decrypt($encryption, $ciphering,
$decryption_key, $options, $decryption_iv);

$test = preg_match('/Id=(.*?),Amount=(.*?),PlayerID=(.*)/', $decryption, $result);

//search database for existing "player id" having "sender id"

if (empty($test))
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
  echo "<i class='fas fa-4x fa-exclamation-circle'></i>";
echo "<h4>Sender or Receiver has submitted wrong Code</h4>";
}

else
{
  $id_of_sender = $result[1];
  $amount_of_sender = $result[2];
  $player_to_trade_id = $result[3];

$sql_sender_player_check = "SELECT * FROM player_info WHERE player_id = '$player_to_trade_id' AND user_id = '$id_of_sender'";
$sql_exec_sender_player_check = mysqli_query($conn,$sql_sender_player_check);

if (($amount_of_receiver == $amount_of_sender) && ($sql_fetch_sender_player_check = mysqli_fetch_assoc($sql_exec_sender_player_check)) && ($id_of_sender != $id_of_receiver))
{
  echo "
  <script>
  $('.loading_modal_wrapper').hide();
  </script>
  ";
// code to exchange player
$sql_plr_exchange_receiver = "UPDATE player_info SET user_id = '$id_of_receiver' WHERE player_id = '$player_to_trade_id'";
$sql_plr_exchange_sender = "UPDATE player_info SET user_id = '$id_of_sender' WHERE player_id = '$player_to_receive_id'";
$sql_exec_plr_exchange_recv = mysqli_query($conn,$sql_plr_exchange_receiver);
$sql_exec_plr_exchange_sndr = mysqli_query($conn,$sql_plr_exchange_sender);

if (($sql_exec_plr_exchange_recv) && ($sql_exec_plr_exchange_sndr))
{
echo "
<script>
$('.loading_modal_wrapper').hide();
</script>
";
echo "<div class='trade_success_message'>
<i class='fas fa-4x fa-check-circle'></i>
<h4>Trade was succesfull!</h4>
</div>";
}
else
{
echo "
<script>
$('.loading_modal_wrapper').hide();
</script>
";
echo "<i class='fas fa-4x fa-exclamation-circle'></i>";
echo "<h4>Sender or Receiver has submitted wrong details</h4>";

}

}

else
{
echo "
<script>
$('.loading_modal_wrapper').hide();
</script>
";
echo "<i class='fas fa-4x fa-exclamation-circle'></i>";
echo "<h4>Sender or Receiver has submitted wrong details</h4>";
}

}

}

                                /* Lan Trade database connection */









                                /* Display player stats databse */
function DisplayPlayerStats()
{
  global $conn;
  $players_id = $_POST['plyr_idd'];

    $sql_plyr = "SELECT * FROM player_info WHERE player_id = '$players_id'";
    $sql_execute_plyr = mysqli_query($conn,$sql_plyr);
    $sql_fetch_plyr = mysqli_fetch_assoc($sql_execute_plyr);
    if ($sql_execute_plyr )
    {
      echo "
      <ul>
        <li>Speed: <span>".$sql_fetch_plyr['player_overall_rating']."</span></li>
        <li>Stamina: <span>70</span></li>
        <li>Evasiveness: <span>70</span></li>
        <li>Agility: <span>70</span></li>
      </ul>
      <ul>
        <li>Attack: <span>70</span></li>
        <li>Defence: <span>70</span></li>
        <li>Special ATK: <span>70</span></li>
        <li>Special DEF: <span>70</span></li>
      </ul>";
    }
    else {
      echo "no";

    }

}










 ?>
