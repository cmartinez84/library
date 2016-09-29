<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
require_once "src/Patron.php";
require_once "src/Book.php";
require_once "src/Checkout.php";
require_once "src/Copy.php";


// require_once "src/.php";



    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


class PatronTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Book::deleteAll();
            Copy::deleteAll();
            Patron::deleteAll();
        }
        function test_getId()
        {
            $id=null;
            $name = "Same";

            $new_patron = new Patron($id, $name);

            $new_patron->save();
            $result = $new_patron->getId();

            $this->assertEquals(true, is_numeric($result));
        }
        function test_getAll()
        {
            $id=null;
            $name = "Same";
            $id1=null;
            $name1 = "Lame";
            $new_patron = new Patron($id, $name);
            $new_patron1 = new Patron($id, $name);

            $new_patron->save();
            $new_patron1->save();

            $this->assertEquals([$new_patron, $new_patron1], Patron::getAll());
        }

        function test_find()
        {
            $id=null;
            $name = "Same";

            $new_patron = new Patron($id, $name);

            $new_patron->save();
            $new_patron_id = $new_patron->getId();

            $result = Patron::find($new_patron_id);

            $this->assertEquals($new_patron, $result);

        }

        function test_delete(){
            $id=null;
            $name = "Same";
            $id1=null;
            $name1 = "Lame";
            $new_patron = new Patron($id, $name);
            $new_patron1 = new Patron($id, $name);

            $new_patron->save();
            $new_patron1->save();


            $new_patron1->delete();

            $this->assertEquals([$new_patron], Patron::getAll());
        }
        function test_update()
        {
            $id=null;
            $name = "Same";

            $new_patron = new Patron($id, $name);
            $new_patron->save();
            $new_patron_id = $new_patron->getId();
            $new_patron->update("Lame");

            $result = Patron::find($new_patron_id);

            $this->assertEquals("Lame", $result->getName());
        }
        function test_history()
        {

            $new_patron = new Patron(null, "Same");
            $new_patron->save();
            $patron_id = $new_patron->getId();

            $new_book = new Book(null, "The Third Chimpanzee", "Jared Diamond");
            $new_book->save();

            $new_book_id = $new_book->getId();
            $new_copy = new Copy(null, $new_book_id);
            $new_copy->save();

            $new_copy->checkOut($patron_id, "2001-11-11");

            $result_array = $new_patron->getHistory();
            $result = $result_array[0];

            $this->assertEquals("The Third Chimpanzee", $result->getTitle());
        }
    }
?>
