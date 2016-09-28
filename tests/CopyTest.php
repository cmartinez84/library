<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
require_once "src/Copy.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


class CopyTest extends PHPUnit_Framework_TestCase
    {
        // protected function tearDown(){
        //     Copy::deleteAll();
        // }

        function test_getId()
        {

            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);

            $new_copy->save();
            $result = $new_copy->getId();

            $this->assertEquals(true, is_numeric($result));
        }


    }
?>
