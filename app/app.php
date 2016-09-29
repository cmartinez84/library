<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Author.php";
    require_once __DIR__."/../src/Book.php";
    require_once __DIR__."/../src/Checkout.php";
    require_once __DIR__."/../src/Copy.php";
    require_once __DIR__."/../src/Patron.php";
    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    use Symfony\Component\HttpFoundation\Request;  Request::enableHttpMethodParameterOverride();

    $app = new Silex\Application();

    $app['debug'] = true;

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'
    ));

    $app->get("/", function() use ($app) {
      return $app['twig']->render('home.html.twig');
    });

    $app->get("/librarian", function() use ($app) {
      return $app['twig']->render('librarian.html.twig', array('allBooks'=> Book::getAll(), 'allPatrons'=> Patron::getAll(), 'patron'=>null));
    });

    $app->post("/librarian/add/patron", function() use ($app) {
        $new_patron = new Patron(null, $_POST['input_name']);
        $new_patron->save();
      return $app['twig']->render('librarian.html.twig', array('allBooks'=> Book::getAll(), 'allPatrons'=> Patron::getAll(), 'patron'=>null));
    });

    $app->get("/librarian/patron/{id}", function($id) use ($app) {
        $found_patron = Patron::find($id);
        var_dump($found_patron);
        return $app['twig']->render('librarian.html.twig', array('allBooks'=> Book::getAll(), 'allPatrons'=> Patron::getAll(), 'patron' =>$found_patron));
    });





    return $app;
?>
