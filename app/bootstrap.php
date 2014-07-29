<?php

require_once 'library/responsive-menu/ResponsiveMenu.php';

require_once 'library/responsive-menu/Registry.php';

Registry::set( 'config', $config );

Registry::set( 'defaults', $defaults );

require_once 'library/responsive-menu/View.php';

require_once 'controllers/BaseController.php';

require_once 'controllers/AdminController.php';

require_once 'controllers/FrontController.php';

require_once 'controllers/GlobalController.php';

require_once 'controllers/InstallController.php';

require_once 'models/BaseModel.php';

require_once 'models/AdminModel.php';

$app = new ResponsiveMenu;