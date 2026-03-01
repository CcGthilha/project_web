<?php
if (insertUser($user)) {
    renderView('signup-success', ['title' => 'สมัครสมาชิกสำเร็จ']); 
}