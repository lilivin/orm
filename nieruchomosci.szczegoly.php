<?php
	require_once 'bootstrap.php';
	require_once 'header.php';

//    $em->getConnection()
//        ->getConfiguration()
//        ->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack())
//    ;

	$miesz = $em->getRepository('Entity\Mieszkanie')->find($_GET['id']);
?>
<table class="table table-stripped">
	<tbody>

		<tr>
            <th>Id</th>
			<td><?=$miesz->getNieruchomosc()->getId() ?></td>
        </tr>
        <tr>
            <th>Typ</th>
			<td><?=$miesz->getNieruchomosc()->getTypOferty() ?></td>
        </tr>
        <tr>
            <th>Województwo</th>
            <td><?=$miesz->getNieruchomosc()->getMiasto()->getPowiat()->getWojewodztwo()->getNazwa() ?></td>
        </tr>
        <tr>
            <th>Powiat</th>
            <td><?=$miesz->getNieruchomosc()->getMiasto()->getPowiat()->getNazwa() ?></td>
        </tr>
        <tr>
            <th>Miasto</th>
            <td><?=$miesz->getNieruchomosc()->getMiasto()->getNazwa() ?></td>
        </tr>
        <tr>
            <th>Powierzchnia</th>
            <td><?=$miesz->getNieruchomosc()->getPowierzchnia() ?></td>
        </tr>
        <tr>
            <th>Cena</th>
            <td><?=$miesz->getNieruchomosc()->getCena() ?></td>
        </tr>
        <tr>
            <th>Cena za m2</th>
            <td><?=$miesz->getNieruchomosc()->getCenaM2() ?></td>
        </tr>

        <tr>
            <th>Piętro</th>
            <td><?=$miesz->getPietro() ?>/<?=$miesz->getLiczbaPieter() ?></td>
        </tr>
        <tr>
            <th>Rok budowy</th>
            <td><?=$miesz->getRokBudowy() ?></td>
        </tr>
        <tr>
            <th>Komunikacja</th>
            <td><?=$miesz->getNieruchomosc()->pobierzKomunikacje() ?></td>
        </tr>
        <tr>
            <th>Dodatkowe informacje</th>
            <td><?=$miesz->getNieruchomosc()->pobierzDodatkowe() ?></td>
        </tr>

	</tbody>
</table>

<?php require_once 'footer.php'; ?>

<?php $logger = $em->getConnection()->getConfiguration()->getSQLLogger(); ?>
<?php if ($logger): ?>
    <ul>
        <?php foreach($logger->queries as $i => $q): ?>
            <li>
                <strong>#<?=$i ?></strong>
                <?=$q['sql'] ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
