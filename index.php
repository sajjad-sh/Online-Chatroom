<?php require_once "libs/auth.php"; ?>
<?php require_once "libs/functions.php"; ?>
<?php require_once "libs/contacts.php"; ?>
<?php
$new_message = array();
$dir_flag = 0;            //0 = left & 1 = right

if ($new_message = prepareMessageData(100)) {
  // echo "<pre>";
  // var_dump($new_message);
  // echo "</pre>";
  saveToFile($new_message, "files/chats.txt");
}

$history = convertFileContentToArray("files/chats.txt");
?>

<html>

<head>

  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" type="text/css" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  <link rel="stylesheet" href="css/style.css">

</head>

<body>
  <div class="container">
    <br>
    <h3>Welcome "<?php echo $_SESSION['username'] ?>". You are In: <a href="index.php">Home</a> » <a href="index.php">Public Room</a></h3> <br>
    <div class="messaging">
      <div class="inbox_msg">
        <div class="inbox_people">
          <div class="headind_srch">
            <div class="recent_heading">
              <h4>Contacts:</h4>
            </div>
            <div class="srch_bar">
              <div class="stylish-input-group">

                <form action="" method="post">
                  <input type="search" name="search" id="search" class="search-bar" placeholder="User or Email">

                  <span class="input-group-addon">
                    <button type="submit" style="cursor: pointer;"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                  </span>

                  <!-- <span class="input-group-addon">
                  <button type="button"> <i class="fa fa-search" aria-hidden="true"></i> </button>
                </span> -->

                </form>
              </div>
            </div>
          </div>

          <div class="inbox_chat">
            <?php for ($i = 0; $i < count($records); $i++) { ?>
              <div class="chat_list active_chat">
                <div class="chat_people">
                  <div class="chat_img">
                    <img src="img/user-profile.png" alt="sunil">
                  </div>

                  <div class="chat_ib">

                    <h5>
                      <a href="<?php echo makePrivateLink($current_user, $records[$i]['username']); ?>">
                        <?php echo $records[$i]['name']; ?>
                      </a>
                    </h5>

                  </div>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>

        <div class="mesgs">
          <div class="msg_history">

            <?php if ($history_chats = showHistoryChat($history, 100)) :
              for ($i = 0; $i < count($history_chats); $i++) {
                if (($i != 0) &&
                  ($history_chats[$i]['sender'] != $history_chats[$i - 1]['sender'])
                ) {
                  if ($dir_flag == 1)
                    $dir_flag = 0;
                  else
                    $dir_flag = 1;
                }
                if ($dir_flag == 1) : ?>
                  <div class="incoming_msg">
                    <div class="incoming_msg_img"> <img src="img/user-profile.png" alt="sunil"> </div>
                    <div class="received_msg">
                      <div class="received_withd_msg">
                        <p><?php echo $history_chats[$i]['message']; ?></p>
                        <span class="time_date">
                          <?php echo 'from <strong>' . $history_chats[$i]['sender'] . '</strong> |'; ?>
                          <?php echo $history_chats[$i]['date']; ?>
                        </span>
                      </div>
                    </div>
                  </div>
                <?php else : ?>
                  <div class="outgoing_msg">
                    <div class="sent_msg">
                      <p><?php echo $history_chats[$i]['message'] ?></p>
                      <span class="time_date">
                        <?php echo 'from <strong>' . $history_chats[$i]['sender'] . '</strong> |'; ?>
                        <?php echo $history_chats[$i]['date']; ?>
                      </span>
                    </div>
                  </div>
                <?php endif; ?>
              <?php } ?>

            <?php else :
              echo "There is'nt any Chat.";
            endif; ?>


          </div>
          <div class="type_msg">
            <form action="" method="post">
              <div class="input_msg_write">
                <input type="text" class="write_msg" name="message" id="message" placeholder="Type a message" />
                <button class="msg_send_btn" type="submit" value="submit"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <p class="text-center top_spac"> Developed by <a target="_blank" href="https://www.linkedin.com/in/sunil-rajput-nattho-singh/">Sajjad Shahrabi</a></p>

    </div>
  </div>
</body>

</html>