<?php

use Phalcon\DI\FactoryDefault,
	Phalcon\Mvc\View,
	Phalcon\Mvc\Url as UrlResolver,
	Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
	Phalcon\Mvc\View\Engine\Volt as VoltEngine,
	Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
	Phalcon\Session\Adapter\Files as SessionAdapter;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->set('url', function() use ($config) {
	$url = new UrlResolver();
	$url->setBaseUri($config->application->baseUri);
	return $url;
}, true);

/**
 * Setting up the view component
 */
$di->set('view', function() use ($config) {

	$view = new View();

	$view->setViewsDir($config->application->viewsDir);

	$view->registerEngines(array(
		'.volt' => function($view, $di) use ($config) {

			$volt = new VoltEngine($view, $di);

			$volt->setOptions(array(
				'compiledPath' => $config->application->cacheDir,
				'compiledSeparator' => '_',
                'compileAlways' => true
			));

			return $volt;
		},
		'.phtml' => 'Phalcon\Mvc\View\Engine\Php'
	));

	return $view;
}, true);

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->set('db', function() use ($config) {
	return new DbAdapter(array(
		'host' => $config->database->host,
		'username' => $config->database->username,
		'password' => $config->database->password,
		'dbname' => $config->database->dbname,
        "options"     => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ),
	));
});

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->set('modelsMetadata', function() {
	return new MetaDataAdapter();
});

/**
 * Start the session the first time some component request the session service
 */
$di->set('session', function() {
	$session = new SessionAdapter();
	$session->start();
	return $session;
});

/**
 * Replace default dispatcher to verify routing access
 */
$di->set('dispatcher', function() use ($di) {

    //Obtain the standard eventsManager from the DI
    $eventsManager = $di->getShared('eventsManager');

    //Instantiate the security plugin
    $security = new Security($di);

    //Listen for events produced in the dispatcher using the Security plugin
    $eventsManager->attach('dispatch', $security);

    $dispatcher = new Phalcon\Mvc\Dispatcher();

    //Bind the EventsManager to the Dispatcher
    $dispatcher->setEventsManager($eventsManager);

    return $dispatcher;
});

//Register user components
$di->set('elements', function(){
    return new Elements();
});

/**
 * Add routing
 */
$di->set('router', function(){
    require __DIR__.'/routes.php';
    return $router;
});

/**
 * Register the flash service with custom css classes
 */
$di->set('flash', function(){
    $flash = new \Phalcon\Flash\Direct(array(
        'error' => 'alert-box alert',
        'success' => 'alert-box success',
        'notice' => 'alert-box secondary',
    ));
    return $flash;
});
/**
 * Register the flashSession service with custom css classes
 */
$di->set('flashSession', function(){
    $flashSession = new \Phalcon\Flash\Session(array(
        'error' => 'alert-box alert',
        'success' => 'alert-box success',
        'notice' => 'alert-box secondary',
    ));
    return $flashSession;
});

/**
 * Set the models cache service
 */
$di->set('modelsCache', function() use ($config) {
    //Cache data for 5 min by default
    //TODO set cache according to production needs
    $frontCache = new \Phalcon\Cache\Frontend\Data(array(
        "lifetime" => 10
    ));

    //Create the component that will cache "Data" to a "File" backend
    //Set the cache file directory - important to keep the "/" at the end of
    //the value for the folder
    //TODO use Memcache or APC in production env
    $cache = new Phalcon\Cache\Backend\File($frontCache, array(
        "cacheDir" =>$config-> application->cacheDir
    ));

    return $cache;
});
