<?php
    $function = 'none';
    if(isset($_GET['add'])) {
        $function = 'add';
        header("Location: add.php?user=".$_GET['user']."&email=".$_GET['email']);
    }
    elseif(isset($_GET['edit'])) {
        header("Location: edit.php?edit=".$_GET['edit']."&user=".$_GET['user']."&email=".$_GET['email']);
    }
    elseif(isset($_GET['remove'])) {
        header("Location: remove.php?remove=".$_GET['remove']);
    }
?>