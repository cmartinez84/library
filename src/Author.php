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
