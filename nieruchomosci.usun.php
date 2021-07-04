<?php
require_once 'bootstrap.php';

$mieszkanie = $em->find(Entity\Mieszkanie::class, $_GET['id']);
$em->remove($mieszkanie);
$em->flush();

header('Location: nieruchomosci.przegladaj.php');






