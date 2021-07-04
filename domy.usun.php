<?php
require_once 'bootstrap.php';

$dom = $em->find(Entity\Dom::class, $_GET['id']);
$em->remove($dom);
$em->flush();

header('Location: domy.przegladaj.php');






