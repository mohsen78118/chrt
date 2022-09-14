<?php
function request ($field) {
    return isset($_REQUEST[$field]) && $_REQUEST[$field]!="" ? $_REQUEST[$field]:null;
}

function has_error3 ($field) {
    global $errors;
    return isset($errors['field']);
}
function get_error3 ($field) {
    global $errors;
    return has_error($field)?$errors['field']:null;
}

$errors=[];
$success=false;

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $comment=request('comment');
}
if (is_null($comment)) {
    echo $errors['field']='pelease take a comment';
}
if (!is_null($comment)) {

    $link=mysqli_connect('localhost:3306','root','');
     if (!$link){
          echo 'error'. mysqli_connect_error();
     }

//    $sql='create database comment2';
    mysqli_select_db($link,'comment2');
//    $sql='create table comment (id int AUTO_INCREMENT, comment varchar(260) not null , primary key (id))';
    $sql="insert into comment(comment) values ('$comment')";
    $result=mysqli_query($link,$sql);
    if ($result) {
        $success=true;
    }else{
        echo 'error 404' .mysqli_error($link);
    }

}
$sql2="select * from comment";
mysqli_select_db($link,'comment2');
$result4=mysqli_query($link,$sql2);
if (!$result4){
    echo 'error'.mysqli_connect_error($link);
}


?>
<html>
<head>
    <title>regaster</title>
    <link rel="stylesheet" href="./css style.css">
</head>
<body>
<h3>take comment...</h3>
<?php if ($success) { ?>
<?php echo 'sended'?>
<?php } ?>
<form action="#" method="post">
    <input type="text" name="comment" placeholder="comment..."> <br> <br>
    <?php if (has_error3('comment')) { ?>
        <span><?php get_error3('comment') ?></span>
    <?php } ?>
    <button type="submit">send</button>
     <div id="table">
    <table>
        <thead>
           <tr>
               <th id="a">title...</th>
               <th id="b">comment</th>
           </tr>
        </thead>
        <tbody>
        <?php while ($user=mysqli_fetch_assoc($result4)) {?>
           <tr>
               <td id="c"><?=$user['id']?></td>
               <td id="d"><?=$user['comment']?></td>

           </tr>
        <?php } ?>
        </tbody>
    </table>
     </div>


</form>
</body>
</html>