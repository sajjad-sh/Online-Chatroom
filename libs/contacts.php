<?php require_once "functions.php"; ?>
    
    <?php 
        $current_user = "";

        if(isset($_SESSION['username']))
            $current_user = $_SESSION['username'];

        if(!empty($current_user) && !file_exists("contacts/$current_user.txt")) {
            $fp = fopen("contacts/$current_user.txt", 'a');
            fwrite($fp, "");
            fclose($fp);
        }

        $search = "";
        $username = "";
        $records = array();

        if(isset($_SESSION['username']))
            $current_user = $_SESSION['username'];

        if(isset($_POST['search']))
            $search = $_POST['search'];

        if($search) {
            $records = convertFileContentToArray("files/users.txt");

            for($i = 0; $i < count($records); $i++) {
                if( $records[$i]['username'] == $search ||
                    $records[$i]['email'] == $search
                ) {
                    saveToFile($records[$i], "contacts/$current_user.txt");
                    break;
                }
            }
        }

        $records = readFromFile("contacts/$current_user.txt");
        if($records==null)
            $records=[];
    ?>

</body>
</html>