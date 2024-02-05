<?php

require_once("connection.php");
require_once("globals.php");

$data = $_POST;

if(!empty($data)) {

    // Create data
    if($data["type"] === "create") {

        $name = $data["name"];
        $phone = $data["phone"];
        $observations = $data["observations"];

        $query = "INSERT INTO contacts (name, phone, observations) VALUES (:name, :phone, :observations)";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato criado com sucesso!";
        } catch(PDOException $e) {
            // conection error
            $error = $e->getMessage();
            echo "Erro: " . $error;
        }
        
    } else if($data["type"] === "edit") {

        $id = $data["id"];
        $name = $data["name"];
        $phone = $data["phone"];
        $observations = $data["observations"];

        $query = "UPDATE contacts SET name = :name, phone = :phone, observations = :observations WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":phone", $phone);
        $stmt->bindParam(":observations", $observations);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato atualizado com sucesso!";
        } catch(PDOException $e) {
            // conection error
            $error = $e->getMessage();
            echo "Erro: " . $error;
        }

    } else if($data["type"] === "delete") {

        $id = $data["id"];

        $query = "DELETE FROM contacts WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "Contato deletado com sucesso!";
        } catch(PDOException $e) {
            // conection error
            $error = $e->getMessage();
            echo "Erro: " . $error;
        }
    }

    //Redirect to home page
    header(("Location:" . $BASE_URL . "../index.php"));

} else {

    $id;

    if(!empty($_GET)) {
        $id = $_GET["id"];
    }

    // Returns contact data
    if(!empty($id)) {

        $query = "SELECT * FROM contacts WHERE id = :id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id",$id);
        $stmt->execute();

        $contact = $stmt->fetch();
        
    } else {
    //Returns all contacts data
        $contacts = [];
        
        $query = "SELECT * FROM contacts";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $contacts = $stmt->fetchAll();

    }
}

//Close connection
$conn = null;