<?php
    Class Patron
    {
        private $id;
        private $name;

        function __construct($id=null, $name){
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
            $GLOBALS['DB']->exec("INSERT INTO patrons (name) VALUES ('{$this->getName()}');");
            $this->id = $GLOBALS['DB']->lastinsertid();
        }
        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE patrons SET name ='{$new_name}';");
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
                $new_patron = new Patron($id, $name);
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
