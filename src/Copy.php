<?php
    Class Copy
    {
        private $id;
        private $book_id;

        function __construct($id, $book_id){
            $this->id = $id;
            $this->book_id = $book_id;
        }
        function getId()
        {
            return $this->id;
        }
        function getBookId()
        {
            return $this->book_id;
        }
        function setBookId($new_book_id)
        {
            $this->book_id = $new_book_id;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO  copies (book_id) VALUES ({$this->getBookId()});");
            $this->id = $GLOBALS['DB']->lastinsertid();
        }
        function getBook(){
            return Book::find($this->getBookId());
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies WHERE id = {$this->getId()};");
        }
        function update($book_id)
        {
            $GLOBALS['DB']->exec("UPDATE copies SET book_id ={$book_id}");
            $this->setBookId($book_id);
        }
        static function find($search_id)
        {
            $returned_copies = Copy::getAll();
            foreach($returned_copies as $copy){
                if($copy->getId() == $search_id)
                {
                    $found_copy = $copy;
                }
            }
            return $found_copy;
        }


        static function getAll()
        {
            $returned_copies = $GLOBALS['DB']->query("SELECT * FROM copies");
            $copies = array();
            foreach($returned_copies as $copy){
                $id = $copy['id'];
                $book_id = $copy['book_id'];
                $new_copy = new Copy($id, $book_id);
                array_push($copies, $new_copy);
            }
            return $copies;
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM copies");
        }
        function checkOut($patron_id, $checkout_date)
        {
            $date = date_create($checkout_date);
            $checkout_date = date_create($checkout_date);
            $due_date = date_add($date, date_interval_create_from_date_string('40 days'));

            $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, due_date, checkout_date, checkin_date) VALUES
            '{$patron_id}',
            '{$this->getId()}',
            '{$due_date}',
            '{$checkout_date}'
            ");
        }


    }
?>
