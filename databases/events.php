<?php
function getEvent(): mysqli_result|bool
{
    global $conn;
    $sql = 'select * from events e join users u on e.user_id = u.user_id join event_images ei on e.event_id = ei.event_id order by e.event_id';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result;
}
