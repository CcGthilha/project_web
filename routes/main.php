<?php
renderView('main', ['title' => 'สวัสดีจ้า', 'upcoming' => getUpcomingEvents(), 'past' => getPastEvents()]);