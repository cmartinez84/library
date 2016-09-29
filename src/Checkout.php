<?php

    class CheckOut
    {
        private $title;
        private $book_id;
        private $checkout_date;
        private $due_date;
        private $checkin_date;

        function __construct($title, $book_id, $checkout_date, $due_date, $checkin_date)
        {
            $this->title = $title;
            $this->book_id = $book_id;
            $this->checkout_date = $checkout_date;
            $this->due_date = $due_date;
            $this->checkin_date = $checkin_date;
        }
        function getTitle()
        {
            return $this->title;
        }
        function getBookId()
        {
            return $this->book_id;
        }
        function getCheckoutDate()
        {
            return $this->checkout_date;
        }
        function geDueDate()
        {
            return $this->due_date;
        }
        function getCheckinDate()
        {
            return $this->checkin_date;
        }
    }
 ?>
