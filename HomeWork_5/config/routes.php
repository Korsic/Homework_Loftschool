<?php

return array(
    'files' => 'users/files', // actionFiles в UsersController
    'users/index' => 'users/index', // actionIndex в UsersController
    'authorization' => 'users/authorization', // actionAuthorization в UsersController
    'registration' => 'users/registration', // actionRegistration в UserController
    '[0-9]+' => 'users/authorization',
);