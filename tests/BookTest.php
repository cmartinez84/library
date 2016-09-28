<?php
// ./vendor/bin/phpunit tests
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Book.php";

    $server = 'mysql:host=localhost;dbname=library_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);


    class BookTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown(){
            Book::deleteAll();
        }

        function test_getTitle()
        {
          $id = null;
          $title = "Great Gatsby";
          $author = "F Scott Fitzgerald";
          $catalog_number = "123.423";
          $new_book = new Book($id, $title, $author, $catalog_number);

          $result = $new_book->getTitle();

          $this->assertEquals($title, $result);
        }

        function test_getId()
        {
          $id = null;
          $title = "Great Gatsby";
          $author = "F Scott Fitzgerald";
          $catalog_number = "123.423";
          $new_book = new Book($id, $title, $author, $catalog_number);

          $new_book->save();

          $this->assertEquals(true, is_numeric($new_book->getId()));

        }

        function test_save()
        {
          $id = null;
          $title = "Great Gatsby";
          $author = "F Scott Fitzgerald";
          $catalog_number = "123.423";
          $new_book = new Book($id, $title, $author, $catalog_number);

          $new_book->save();

          $this->assertEquals([$new_book], Book::getAll());
        }
        function test_getAll()
        {
          $id = null;
          $title = "Great Gatsby";
          $author = "F Scott Fitzgerald";
          $catalog_number = "123.423";
          $new_book = new Book($id, $title, $author, $catalog_number);


          $id = null;
          $title = "The Siren of Titans";
          $author = "Tim Robbins";
          $catalog_number = "142.973";
          $new_book2 = new Book($id, $title, $author, $catalog_number);

          $new_book->save();
          $new_book2->save();

          $this->assertEquals([$new_book, $new_book2], Book::getAll());
        }
        function test_find(){
            $id = null;
            $title = "Great Gatsby";
            $author = "F Scott Fitzgerald";
            $catalog_number = "123.423";
            $new_book = new Book($id, $title, $author, $catalog_number);
            $new_book->save();
            $new_book_id = $new_book->getId();

            $result = Book::find($new_book_id);

            $this->assertEquals($new_book, $result);

        }
        function test_delete(){
            $id = null;
            $title = "Great Gatsby";
            $author = "F Scott Fitzgerald";
            $catalog_number = "123.423";
            $new_book = new Book($id, $title, $author, $catalog_number);


            $id = null;
            $title = "The Siren of Titans";
            $author = "Tim Robbins";
            $catalog_number = "142.973";
            $new_book2 = new Book($id, $title, $author, $catalog_number);

            $new_book->save();
            $new_book2->save();
            $new_book2->delete();

            $this->assertEquals([$new_book], Book::getAll());
        }
        function test_update(){
            $id = null;
            $title = "Great Gatsby";
            $author = "F Scott Fitzgerald";
            $catalog_number = "123.423";
            $new_book = new Book($id, $title, $author, $catalog_number);
            $new_book->save();
            $new_book->update("The Sun Also Rises", "Hemmingway", "344.444");
            $new_book_id= $new_book->getId();

            $updated_book = Book::find($new_book_id);

            $this->assertEquals("The Sun Also Rises", $updated_book->getTitle());

        }
    }
?>
