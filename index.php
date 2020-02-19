<?php

if (!isset($_SESSION)) {
	session_start();
}

require_once 'config/config.php';
require_once 'config/paths.php';

require_once 'libs/Bootstrap.php';
require_once 'libs/Database.php';
require_once 'libs/Form.php';
require_once 'libs/Cookie.php';
require_once 'libs/Controller.php';
require_once 'libs/Model.php';
require_once 'libs/View.php';
require_once 'libs/Hash.php';
require_once 'libs/Session.php';

require_once 'utils/Auth.php';
require_once 'utils/helpers.php';
require_once 'utils/Validator.php';

require_once 'models/user_tokens_model.php';


$app = new Bootstrap;
