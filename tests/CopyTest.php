<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
require_once "src/Copy.php";
require_once "src/Book.php";



    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


class CopyTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Copy::deleteAll();
        }

        function test_getId()
        {
            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);

            $new_copy->save();
            $result = $new_copy->getId();

            $this->assertEquals(true, is_numeric($result));
        }
        function test_save()
        {
            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);

            $new_copy->save();
            $result = Copy::getAll();

            $this->assertEquals([$new_copy], $result);
        }
        function test_delete(){
            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);
            $new_copy->save();

            $id2 =null;
            $book_id2 =3;
            $new_copy2 = new Copy($id, $book_id);
            $new_copy2->save();

            $new_copy2->delete();

            $this->assertEquals([$new_copy], Copy::getAll());
        }
        function test_getBook()
        {
            $id = null;
            $title = "Great Gatsby";
            $author = "F Scott Fitzgerald";
            $new_book = new Book ($id, $title, $author);
            $new_book->save();

            $new_copy = new Copy($id, $new_book->getId());
            $result = $new_copy->getBook();

            $this->assertEquals($new_book, $result);
        }
        function test_find()
        {
            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);

            $new_copy->save();
            $new_copy_id = $new_copy->getId();

            $result = Copy::find($new_copy_id);

            $this->assertEquals($new_copy, $result);

        }
        function test_update()
        {
            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);
            $new_copy->save();
            $new_copy_id = $new_copy->getId();
            $new_copy->update(44);

            $updated_copy = Copy::find($new_copy_id);

            $this->assertEquals(44, $updated_copy->getBookId());
        }
        function test_checkout()
        {
            $id =null;
            $book_id =3;
            $new_copy = new Copy($id, $book_id);
            $new_copy->save();

            $result = $new_copy->checkOut(234, "2000-01-11");
            $this->assertEquals("2000-01-25", $result);
        }





    }
?>
