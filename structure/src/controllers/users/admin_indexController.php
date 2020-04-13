<?php
$sql = 'SELECT id, email, created FROM users ORDER BY created DESC';
$request = $db->query($sql);
$data = $request->fetchAll();
