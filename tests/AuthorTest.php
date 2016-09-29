<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */
require_once "src/Author.php";
require_once "src/Book.php";

    $server = 'mysql:host=localhost:8889;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


class AuthorTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Author::deleteAll();
        }
        function test_getId()
        {
            $id =null;
            $name = "Jerry Diamond";
            $new_author = new Author($id, $name);

            $new_author->save();
            $result = $new_author->getId();
            $this->assertEquals(true, is_numeric($result));
        }
        function test_save()
        {
            $id =null;
            $name = "Jerry Diamond";
            $new_author = new Author($id, $name);

            $new_author->save();
            $result = Author::getAll();
            $this->assertEquals([$new_author], $result);
        }
        function test_getAll()
        {
            $id =null;
            $name = "Jerry Diamond";
            $new_author = new Author($id, $name);

            $id2 =null;
            $name2 = "Aldous Huxley";
            $new_author2 = new Author($id, $name);

            $new_author->save();
            $new_author2->save();

            $result = Author::getAll();

            $this->assertEquals([$new_author, $new_author2], $result);
        }
        function test_find()
        {
            $id =null;
            $name = "Jerry Diamond";
            $new_author = new Author($id, $name);
            $new_author->save();
            $new_author_id = $new_author->getId();

            $result = Author::find($new_author_id);

            $this->assertEquals($new_author, $result);
        }
        function test_addBooks()
        {
            $new_author = new Author(null, "Jared Diamond");
            $new_author->save();
            $new_book = new Book(null, "The Third Chimpanzee", "Jared Diamond");
            $new_book->save();
            $new_book_id = $new_book->getId();
            $new_author->addBook($new_book_id);

            $result = $new_author->getBooks();

            $this->assertEquals([$new_book], $result);

        }

    }
?>
