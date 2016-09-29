<?php
    Class Copy
    {
        private $id;
        private $book_id;
        private $available;

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
        static function numberOfCopies($book_id)
        {
            $result = $GLOBALS['DB']->query("SELECT COUNT(book_id) FROM copies WHERE book_id={$book_id};");
            foreach($result as $a){
                return $a[0];
            }
        }
        static function availableCopies($book_id){
            $result = $GLOBALS['DB']->query("SELECT COUNT(book_id) FROM copies WHERE book_id={$book_id} AND availble = 1;");
            foreach($result as $a){
                return $a[0];
            }
        }
        function checkOut($patron_id, $checkout_date)
        {
            $date = date_create($checkout_date);
            $due_date = date_add($date, date_interval_create_from_date_string('14 days'));
            $formatted_due_date = $due_date->format('Y-m-d');
            $GLOBALS['DB']->exec("INSERT INTO checkouts (patron_id, copy_id, checkout_date, due_date) VALUES
            (
                {$patron_id},
                {$this->getId()},
                '{$checkout_date}',
                '{$formatted_due_date}'
            );");
            $GLOBALS['DB']->exec("UPDATE copy SET available = 0 WHERE id={$this->getId()};");
            return $formatted_due_date;
        }
        function checkIn ($checkin_date)
        {
            $GLOBALS['DB']->exec("UPDATE checkouts SET
            checkin_date = '{$checkin_date}'
            WHERE copy_id={$this->getId()} AND checkin_date IS NULL;");
            $checkout_data = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE copy_id = {$this->getId()};");
            $GLOBALS['DB']->exec("UPDATE copy SET available = 1 WHERE id={$this->getId()};");
            $patron_id = "";
            foreach($checkout_data as $data){
                $datetime1 = new DateTime($data['due_date']);
                $datetime2 = new DateTime($checkin_date);
                $interval = $datetime1->diff($datetime2);
                $days_overdue = $interval->format('%R%a');
                $patron_id = $data['patron_id'];
            }
            if($days_overdue > 0){
                $fine =$days_overdue * 0.25;
                $GLOBALS['DB']->exec("UPDATE patrons SET fine = fine + {$fine} WHERE id='{$patron_id}'");

                return $days_overdue;
            }
        }

    }
?>
