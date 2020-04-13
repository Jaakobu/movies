<?php
// Users
$router->map('GET', '/admin', 'users/admin_index.php', 'usersList');
$router->map('GET', '/admin/users/delete/[i:id]', 'users/admin_delete.php', 'usersDelete');
$router->map('GET|POST', '/admin/users/add', 'users/admin_add.php', 'usersAdd');
$router->map('GET|POST', '/admin/users/add/[i:id]', 'users/admin_add.php', 'usersUpdate');


// Movies
$router->map('GET', '/admin/movies', 'movies/admin_index.php', 'moviesList');
$router->map('GET', '/admin/movies/delete/[i:id]', 'movies/admin_delete.php', 'moviesDelete');
$router->map('GET|POST', '/admin/movies/add', 'movies/admin_add.php', 'moviesAdd');
$router->map('GET|POST', '/admin/movies/add/[i:id]', 'movies/admin_add.php', 'moviesUpdate');