<?php

    require_once("models/Contact.php");
    require_once("models/Message.php");

    class ContactDAO implements ContactDAOInterface {

        private $conn;
        private $url;
        private $message;

        public function __construct(PDO $conn, $url) {

            $this->conn = $conn;
            $this->url = $url;
            $this->message = new Message($url);

        }

        public function buildContact($data) {

            $contact = new Contact();

            $contact->id = $data["id"];
            $contact->name = $data["name"];
            $contact->phone = $data["phone"];
            $contact->observations = $data["observations"];
            $contact->users_id = $data["users_id"];

            return $contact;

        }

        public function getContactsByUserId($id) {

            $contacts = [];

            $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE users_id = :users_id");

            $stmt->bindParam(":users_id", $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $contactArrays = $stmt->fetchAll();

                foreach ($contactArrays as $contact) {

                    $contacts[] = $this->buildContact($contact);

                }

                return $contacts;

            } else {

                return false;

            }

        }

        public function findById($id) {

            $contact = [];

            $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE id = :id");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $contactData = $stmt->fetch();

                $contact = $this->buildContact($contactData);

                return $contact;

            } else {

                return false;

            }

        }

        public function findByName($name, $id) {

            $contacts = [];

            $stmt = $this->conn->prepare("SELECT * FROM contacts WHERE name LIKE :name AND users_id = :users_id");

            $stmt->bindValue(":name", "%".$name."%");
            $stmt->bindParam(":users_id", $id);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {

                $contactArrays = $stmt->fetchAll();

                foreach ($contactArrays as $contact) {

                    $contacts[] = $this->buildContact($contact);

                }

            }

            return $contacts;

        }

        public function create(Contact $contact) {

            $stmt = $this->conn->prepare("INSERT INTO contacts (name, phone, observations, users_id) VALUES (:name, :phone, :observations, :users_id)");

            $stmt->bindParam(":name", $contact->name);
            $stmt->bindParam(":phone", $contact->phone);
            $stmt->bindParam(":observations", $contact->observations);
            $stmt->bindParam(":users_id", $contact->users_id);

            $stmt->execute();
            
            $this->message->setMessage("Contato adicionado com sucesso!", "success", "index.php");

        }

        public function update(Contact $contact) {

            $stmt = $this->conn->prepare("UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id = :id");

            $stmt->bindParam(":name", $contact->name);
            $stmt->bindParam(":phone", $contact->phone);
            $stmt->bindParam(":observations", $contact->observations);
            $stmt->bindParam(":id", $contact->id);

            $stmt->execute();

            $this->message->setMessage("Contato atualizado com sucesso!", "success", "index.php");

        }

        public function destroy($id) {

            $stmt = $this->conn->prepare("DELETE FROM contacts WHERE id = :id");

            $stmt->bindParam(":id", $id);

            $stmt->execute();

            $this->message->setMessage("Contato removido com sucesso!", "success", "index.php");

        }


    }