<?php
    if (isset($_POST['redirect']))
        header('Location: ' . $_POST['redirect']);
    else
        header('Location: /');

    require __DIR__ . '/../../../../wp-config.php';

    try {
        $dbh = new PDO('mysql:host=' . DB_HOST. ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        die();
    }

    try {
        $sql = sprintf('SELECT
                option_name,
                option_value
            FROM
                %soptions
            WHERE option_name LIKE "%s"', $table_prefix, '%splash_page%');

        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        $results = $stmt->fetchAll(\PDO::FETCH_OBJ);
    } catch (\PDOException $e) {
        die();
    }

    foreach ($results as $r)
        $options[$r->option_name] = $r->option_value;

    $to = $options['splash_page_to_mail'];
    $subject = isset($options['splash_page_subject']) ? $options['splash_page_subject'] : 'New Lead';
    $message = sprintf("Name: %s\nEmail: %s", $_POST['name'], $_POST['email']);

    mail($to, $subject, $message);

    $sql = "INSERT INTO leads (name, email, page)
        VALUES
            (:name, :email, :page)";

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':name',  $_POST['name']);
    $stmt->bindParam(':email',  $_POST['email']);
    $stmt->bindParam(':page',  $_POST['page']);

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        die();
    }