<?php
$sql = 'SELECT id, title, created FROM movies ORDER BY created DESC';
$request = $db->query($sql);
$data = $request->fetchAll();
