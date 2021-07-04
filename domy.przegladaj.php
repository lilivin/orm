<?php
	require_once 'bootstrap.php';
	require_once 'header.php';

//    $em->getConnection()
//        ->getConfiguration()
//        ->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack())
//    ;

	$domy = $em->getRepository('Entity\Dom')->pobierzWszystko();
//dd($domy);
	?>
<table class="table table-stripped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Typ</th>
            <th>Województwo</th>
            <th>Powiat</th>
			<th>Miasto</th>
			<th>Powierzchnia</th>
			<th>Cena</th>
			<th>Powierzchnia działki</th>
			<th>Rok budowy</th>
			<th>Komunikacja</th>
            <th>Dodatkowe informacje</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($domy as $dom): ?>
		<tr>
			<td><?=$dom->getNieruchomosc()->getId() ?></td>
			<td><?=$dom->getNieruchomosc()->getTypOferty() ?></td>
            <td><?=$dom->getNieruchomosc()->getMiasto()->getPowiat()->getWojewodztwo()->getNazwa() ?></td>
            <td><?=$dom->getNieruchomosc()->getMiasto()->getPowiat()->getNazwa() ?></td>
			<td><?=$dom->getNieruchomosc()->getMiasto()->getNazwa() ?></td>
			<td><?=$dom->getNieruchomosc()->getPowierzchnia() ?></td>
			<td><?=$dom->getNieruchomosc()->getCena() ?></td>
			<td><?=$dom->getPowierzchniaDzialki() ?></td>
			<td><?=$dom->getRokBudowy() ?></td>
			<td><?=$dom->getNieruchomosc()->pobierzKomunikacje() ?></td>
            <td><?=$dom->getNieruchomosc()->pobierzDodatkowe() ?></td>
			<td>
				<a href="domy.szczegoly.php?id=<?=$dom->getId() ?>">szczegóły</a> |
				<a href="domy.edycja.php?id=<?=$dom->getId() ?>">edycja</a> |
				<a href="domy.usun.php?id=<?=$dom->getId() ?>">usuń</a>
			</td>
		</tr>
		<?php endforeach; ?>
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
