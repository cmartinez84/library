<?php
    Class Book
    {
      private $id;
      private $title;
      private $author;
      private $catalog_number;

      function __construct($id=null, $title, $author, $catalog_number=null)
       {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->catalog_number = $catalog_number;
       }
        function getId()
        {
          return $this->id;
        }
        function getTitle()
        {
          return $this->title;
        }
        function setTitle($new_title)
        {
          $this->title = $new_title;
        }
        function getAuthor()
        {
          return $this->author;
        }
        function setAuthor($new_author)
        {
          $this->author = $new_author;
        }
        function getcatalog_number()
        {
          return $this->catalog_number;
        }
        function setcatalog_number($new_catalog_number)
        {
          $this->catalog_number = $new_catalog_number;
        }
        function save()
        {
        $GLOBALS['DB']->exec("INSERT INTO books (title, author, catalog_number) VALUES (
            '{$this->getTitle()}',
            '{$this->getAuthor()}',
            '{$this->getcatalog_number()}'
        );");

          $this->id = $GLOBALS['DB']->lastInsertId();
        }
        function saveMultiple($numberOfCopies)
        {
            for ($x = 0; $x < $numberOfCopies; $x++) {
                $new_copy = new Copy(null, $this->getId());
                $new_copy->save();
            }
        }
        function updateMultiple($numberToChage)
        {

        }
        function delete()
        {
          $GLOBALS['DB']->exec("DELETE FROM books WHERE id={$this->getId()};");
        }
        function update($new_title, $new_author, $new_catalog_number)
        {
            $GLOBALS['DB']->exec("UPDATE books SET
                title ='{$new_title}',
                author ='{$new_author}',
                catalog_number = '{$new_catalog_number}'
                WHERE id={$this->getId()};");
            $this->setTitle($new_title);
            $this->setAuthor($new_author);
            $this->setcatalog_number($new_catalog_number);
        }
        static function deleteAll()
        {
          $GLOBALS['DB']->exec("DELETE FROM books;");
        }
        static function getAll()
        {
            $returned_books = $GLOBALS['DB']->query("SELECT * FROM books;");
            $books = array();
            foreach($returned_books as $book){
              $id = $book['id'];
              $title = $book['title'];
              $author = $book['author'];
              $catalog_number = $book['catalog_number'];
              $new_book = new Book($id, $title, $author, $catalog_number);
              array_push($books, $new_book);
          }
          return $books;
        }
        static function find($search_id){
            $returned_books = Book::getAll();
            foreach($returned_books as $book){
                if($book->getId() == $search_id){
                    $found_book = $book;
                }
            }
            return $found_book;
        }
        function addAuthor()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES ({$author_id}, {$this->getId()},);");
        }

        function getAuthors()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT authors.* FROM books JOIN authors_books ON (books.id = authors_books.book_id) JOIN authors ON (authors_books.author_id = authors.id) WHERE books.id = {$this->getId()};");

            $authors = array();
            foreach($returned_authors as $author){
              $id = $author['id'];
              $name= $author['name'];
              $new_author = new Author($id, $name);
              array_push($authors, $new_author);
          }
          return $authors;
        }




    }

 ?>
