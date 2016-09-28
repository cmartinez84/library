<?php

    class Author
    {
        private $id;
        private $name;

        function __construct($id, $name){
            $this->id = $id;
            $this->name = $name;
        }
        function getId()
        {
            return $this->id;
        }
        function getName()
        {
            return $this->name;
        }
        function setName($new_name)
        {
            $this->name = $new_name;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO authors(name) VALUES ('{$this->getName()}')");
            $this->id = $GLOBALS['DB']->lastinsertid();
        }
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors WHERE id={$this->getId()};");
        }
        function addBook($book_id)
        {
            $GLOBALS['DB']->exec("INSERT INTO authors_books (author_id, book_id) VALUES
            ({$this->getId()},{$book_id});");
        }
        function getBooks(){
            $returned_books = $GLOBALS['DB']->query("SELECT books.* FROM authors
            JOIN authors_books ON (authors.id = authors_books.author_id)
            JOIN books ON (authors_books.book_id = books.id)
            WHERE authors.id = {$this->getId()};");

            $books = array();
            foreach($returned_books as $book){
              $id = $book['id'];
              $title = $book['title'];
              $author = $book['author'];
              $new_book = new Book($id, $title, $author);
              array_push($books, $new_book);
          }
          return $books;
        }

        static function getAll()
        {
            $returned_authors = $GLOBALS['DB']->query("SELECT * FROM authors");
            $authors = array();
            foreach($returned_authors as $author){
                $id = $author['id'];
                $name = $author['name'];
                $new_author = new Author($id, $name);
                array_push($authors, $new_author);
            }
            return $authors;
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM authors;");
        }
        static function find($search_id)
        {
            $returned_authors = Author::getAll();
            foreach($returned_authors as $author){
                if($author->getId() == $search_id){
                    $found_author = $author;
                }
            }
            return $found_author;
        }
    }

?>
