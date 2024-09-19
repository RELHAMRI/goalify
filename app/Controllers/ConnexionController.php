<?php
require_once(__DIR__ . '/../Utils/checkForm.php');

$arrayError = [];

if (isset($_POST['mail'])) {
    check('mail', $_POST['mail']);
    check('password', $_POST['password']);

    if (empty($arrayError)) {
        $mail = htmlspecialchars($_POST['mail']);
        $password = htmlspecialchars($_POST['password']);

        $userQuery = "SELECT `mail`, `password` FROM `user` WHERE mail = :mail";
        $userStatement = $mysqlClient->prepare($userQuery);
        $userStatement->bindParam(':mail', $mail);
        $userStatement->execute();

        $user = $userStatement->fetch();

        if (!$user) {
            redirectToRoute('/register');
        } else {
            // Pour vérifier le mot de passe haché, on utilise password_verif
            // Dans la variable $verif on aura TRUE/FALSE
            $verif = password_verify($password, $user['password']);
            if (!$verif) {
                redirectToRoute('/connexion');
            } else {

                $userQuery = "SELECT `user`.`id`, `user`.`pseudo`, `user`.`mail`, `user`.`id_role`
                FROM `user`
                INNER JOIN `role` ON `user`.`id_role` = `role`.`id`
                WHERE mail = :mail";
                $userStatement = $mysqlClient->prepare($userQuery);
                $userStatement->bindParam(':mail', $mail);
                $userStatement->execute();

                $user = $userStatement->fetch();

                $_SESSION['user'] = [
                    'id' => uniqid(),
                    'mail' => $user['mail'],
                    'pseudo' => $user['pseudo'],
                    'register_date' => $user['register_date'],
                    'rôle' => $user['name'],
                    'idUser' => $user['id']
                ];

                redirectToRoute('/');
            }
        }
    }
}
require_once(__DIR__ . '/../Views/security/connexion.view.php');
