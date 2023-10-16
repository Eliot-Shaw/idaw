<?php
    $function = 'none';
    if(isset($_GET['add'])) {
        $function = 'add';
        header("Location: add.php?user=".$_GET['user']."&email=".$_GET['email']);
    }
    elseif(isset($_GET['edit'])) {
        header("Location: users.php?edit=".$_GET['edit']);
    }
    elseif(isset($_GET['validate'])) {
        header("Location: update.php?update=".$_GET['validate']."&user=".$_GET['user']."&email=".$_GET['email']);
    }
    elseif(isset($_GET['remove'])) {
        header("Location: remove.php?remove=".$_GET['remove']);
    }
?>