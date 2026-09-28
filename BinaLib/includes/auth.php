<?php
declare(strict_types=1);
if(session_status()!==PHP_SESSION_ACTIVE)session_start();
function require_admin():void{
    if(empty($_SESSION['bls_admin_id'])){header('Location: index.php');exit;}
}
