<?php

class Contact {

    public $id;
    public $name;
    public $phone;
    public $observations;
    public $users_id;

}

interface ContactDAOInterface {

    public function buildContact($data);
    public function getContactsByUserId($id);
    public function findById($id);
    public function findByName($name);
    public function create(Contact $contact);
    public function update(Contact $contact);
    public function destroy($id);

}