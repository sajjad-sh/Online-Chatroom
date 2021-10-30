<?php require_once "jalali-date.php" ?>
<?php require_once "session.php"; ?>
<?php

ini_set('upload_max_filesize', '10M');

function makeNewUser() {
    if (
        isset($_POST['name']) && isset($_POST['username']) &&
        isset($_POST['email']) && isset($_POST['password'])
    ) {
        $new_user['name'] = $_POST['name'];
        $new_user['username'] = $_POST['username'];
        $new_user['email'] = $_POST['email'];
        $new_user['password'] = md5($_POST['password']);
        return $new_user;
    }
    return false;
}

function makeNewChat($chat_file_name) {
    $new_message = array();

    if (isset($_POST['message'])) {
        $new_message['message'] = $_POST['message'];

        $now_date = date("y-m-d", time());
        $new_message['date'] = toJalali($now_date);
        $new_message['sender'] = $_SESSION['username'];

        saveToFile($new_message, $chat_file_name);

        return $new_message;
    }
    return false;
}

function saveToFile(array $new_record, $file_name) {
    $records = array();

    $json = file_get_contents($file_name);
    $records = json_decode($json, true);

    $is_user = strpos($file_name, "users.txt");

    if ($is_user !== false) {
        for ($i = 0; $i < count($records); $i++) {
            if (($new_record['username'] == $records[$i]['username']))
                die("This User already exists.");
        }
    }

    $records[] = $new_record;

    $json = json_encode($records);
    file_put_contents($file_name, $json);

    return $records;
}

function writeAndDelete(array $records, $file_name) {
    $json = json_encode($records, JSON_FORCE_OBJECT);
    file_put_contents($file_name, $json);
}

function readFromFile($file_name) {
    $records = array();

    $json = file_get_contents($file_name);
    $records = json_decode($json, true);

    return $records;
}

function convertFileContentToArray($file_name) {
    $json = file_get_contents($file_name);
    $records = json_decode($json, true);

    return $records;
}


function prepareMessageData($limit = false) {

    if(!empty($_FILES['file']['name']) &&
        $_FILES['file']['size'] <= 10485760 &&
        ($_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png")
        ) { 
        $new_message['file']['name'] = $_FILES['file']['name'];
        $new_message['file']['type'] = $_FILES['file']['type'];
        $new_message['file']['tmp_name'] = $_FILES['file']['tmp_name'];
        $new_message['file']['size'] = $_FILES['file']['size'];

        move_uploaded_file($new_message['file']['tmp_name'], "pictures/" . $new_message['file']['name']);

        $new_message['file']['tmp_name'] = "pictures/" . $new_message['file']['name'];

        $now_date = date("y-m-d", time());
        $new_message['date'] = toJalali($now_date);

        $new_message['sender'] = $_SESSION['username'];
        
        return $new_message;
    }


    elseif (isset($_POST['message']) && !empty($_POST['message'])) {
        if (($limit === false) || ($_POST['message'] <= $limit)) {
            $new_message['message'] = $_POST['message'];

            $now_date = date("y-m-d", time());
            $new_message['date'] = toJalali($now_date);

            $new_message['sender'] = $_SESSION['username'];

            return $new_message;
        }
        else
            return false;
    }
    return false;
}

function showHistoryChat(array $history, $count_of_messages) {
    $i = count($history) > $count_of_messages ? count($history) - $count_of_messages : 0;
    $h = count($history) > $count_of_messages ? $count_of_messages : count($history);

    $history_chats = array();

    if (!empty($history)) {
        for ($i, $j = 0; $i < count($history), $j < $h; $i++, $j++) {
            $history_chats[$j]['sender'] = $history[$i]['sender'];
            $history_chats[$j]['date'] = $history[$i]['date'];
            if(isset($history[$i]['message']))
                $history_chats[$j]['message'] = $history[$i]['message'];
            elseif(isset($history[$i]['file']))
                $history_chats[$j]['file'] = $history[$i]['file'];
        }
        return $history_chats;
    } else
        return false;
}

function register() {
    $user_exists = false;

    $users = readFromFile("../files/users.txt");

    if ($new_user = makeNewUser()) {
        $name = $new_user['name'];
        $username = $new_user['username'];
        $email = $new_user['email'];
        $password = $new_user['password'];

        $user_exists = false;

        for ($i = 0; $i < count($users); $i++) {
            if (($username == $users[$i]['username']) || ($email == $users[$i]['email'])) {
                $user_exists = true;
                break;
            }
        }

        if (!$user_exists) {
            setSession('name', $name);
            setSession('username', $username);
            setSession('email', $email);
            setSession('password', $password);

            saveToFile($new_user, "../files/users.txt");

            $host = $_SERVER['HTTP_HOST'];

            header("Location: http://$host/index.php");
            exit();
        } else
            echo "There is user with this username or email.";
    }
}

function login() {
    require_once "session.php";

    $users = readFromFile("../files/users.txt");

    $username = '';
    $password = '';

    $user_exists = true;

    if (isset($_POST['username']))
        $username = $_POST['username'];

    if (isset($_POST['password']))
        $password = md5($_POST['password']);

    if ($username && !empty($users)) {
        for ($i = 0; $i < count($users); $i++) {
            if (($username == $users[$i]['username']) && ($password == $users[$i]['password'])) {
                setSession('username', $username);
                setSession('password', $password);

                $host = $_SERVER['HTTP_HOST'];

                header("Location: http://$host/index.php");
                exit();
            } else
                $user_exists = false;
        }
    } else
        $user_exists = false;

    if ($user_exists == false)
         return false;
    else
        return true;
}

function makePrivateLink($user1, $user2) {
    if(strcmp($user1, $user2)<=0)
        return "private.php?user1=$user1&user2=$user2";
    
    return "private.php?user1=$user2&user2=$user1";
}