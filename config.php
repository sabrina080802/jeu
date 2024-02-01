<?php

/** Environment mode defines what Magy can do :
 * -> dev : In development mode, Magy can run any scripts
 
 * -> deploy : In deploy mode, Magy can run deploy.php. 
 *            It may create the database and configure the environment to run the project correctly.
 *            After running deploy.php, Magy goes to prod mode automatically
 
 * -> update : In update mode, Magy can run update.php and restore.php. 
 *            It may check the database and explore differences of it's previously generated entities and update the db structure.
 *            restore.php is used to restore a previously maded backup
 
 * -> prod : In production mode, Magy can't run anything else than the project itself and backup.php
 */
const ENV_MODE = 'dev';


/** Magy paths */
const MAGY_PATH = __DIR__ . '/magy/';
const CONFIG_PATH = __DIR__ . '/config/';


/** Applications paths */
const ROOT_PATH = '/dossier/';

//Php
const PRIVATE_APP_PATH = __DIR__ . '/private/';
const API_PATH = __DIR__ . '/private/api/';
const CONTROLLERS_PATH = __DIR__ . '/private/controllers/';

//Views
const VIEW_PATH = __DIR__ . '/public/views/';
const TEMPLATES_PATH = __DIR__ . '/public/template/';

//Styling
const CSS_PATH = __DIR__ . '/public/css/';

//JS
const JS_PATH = __DIR__ . '/public/js/';

//Files
const FILES_PATH = __DIR__ . '/public/files/';
const FONTS_PATH = __DIR__ . '/public/fonts/';
const IMAGES_PATH = __DIR__ . '/public/images/';
