<?php
renderView('personal', ['title' => 'ข้อมูลส่วนตัว', 'result' => getUserById($_SESSION['user_id'])]);