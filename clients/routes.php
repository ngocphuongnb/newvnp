<?php

Router::UnMap('LoginAction');
Router::UnMap('LogoutAction');
Router::Map('LoginAction', '/login', 'User#Login', 'POST');
Router::Map('LogoutAction', '/logout', 'User#Logout', 'GET|POST');

?>