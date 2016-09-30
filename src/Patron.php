<?php
    Class Patron
    {
        private $id;
        private $name;
        private $fine;
        private $titles;


        function __construct($id=null, $name, $fine = 0){
            $this->id = $id;
            $this->name = $name;
            $this->fine = $fine;
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
        function getFine()
        {
            return $this->fine;
        }
        function setFine($new_fine)
        {
            $this->fine = $new_fine;
        }
        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO patrons (name, fine) VALUES ('{$this->getName()}',{$this->getFine()});");
            $this->id = $GLOBALS['DB']->lastinsertid();
        }
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name ='{$new_name}' WHERE id={$this->getId()};");
        }
        function updateBalance($new_fine){
            $GLOBALS['DB']->exec("UPDATE patrons SET fine ='{$new_fine}' WHERE id={$this->getId()};");
        }
         function getHistory()
        {
            $histories = $GLOBALS['DB']->query("SELECT * FROM checkouts WHERE patron_id={$this->getId()};");
            $checkout_history = array();
            foreach($histories as $history){
                $copy_id = $history['copy_id'];
                $found_copy = Copy::find($copy_id);
                $found_book = $found_copy->getBook();
                //construct checkout
                $book_id = $found_book->getId();
                $title =  $found_book->getTitle();
                $checkout_date = $history['checkout_date'];
                $due_date = $history['due_date'];
                $checkin_date = $history['checkin_date'];
                $found_checkout = new Checkout($title, $book_id, $checkout_date, $due_date, $checkin_date);
                array_push($checkout_history, $found_checkout);
            }
            return $checkout_history;
        }

        static function deleteAll(){
            $GLOBALS['DB']->exec("DELETE FROM patrons");
        }
        static function getAll()
        {
            $returned_patrons = $GLOBALS['DB']->query("SELECT * FROM patrons");
            $patrons = array();
            foreach($returned_patrons as $patron){
                $id = $patron['id'];
                $name= $patron['name'];
                $fine = $patron['fine'];
                $new_patron = new Patron($id, $name, $fine);
                array_push($patrons, $new_patron);
            }
            return $patrons;
        }
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM patrons WHERE id={$this->getId()}");
        }
        static function find($search_id)
        {
            $returned_patrons = Patron::getAll();
            foreach($returned_patrons as $patron){
                if($patron->getId() == $search_id)
                {
                    $found_patron = $patron;
                }
            }
            return $found_patron;
        }

    }
?>
