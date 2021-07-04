<?php
require_once 'bootstrap.php';

$grunt = $em->find(Entity\Grunt::class, $_GET['id']);
$em->remove($grunt);
$em->flush();

header('Location: grunty.przegladaj.php');






