<?php
	require_once 'bootstrap.php';
	require_once 'header.php';

//    $em->getConnection()
//        ->getConfiguration()
//        ->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack())
//    ;

	$grunty = $em->getRepository('Entity\Grunt')->pobierzWszystko();
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
			<th>Pozwolenie na budowę</th>
			<th>Komunikacja</th>
            <th>Dodatkowe informacje</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($grunty as $grunt): ?>
		<tr>
			<td><?=$grunt->getNieruchomosc()->getId() ?></td>
			<td><?=$grunt->getNieruchomosc()->getTypOferty() ?></td>
            <td><?=$grunt->getNieruchomosc()->getMiasto()->getPowiat()->getWojewodztwo()->getNazwa() ?></td>
            <td><?=$grunt->getNieruchomosc()->getMiasto()->getPowiat()->getNazwa() ?></td>
			<td><?=$grunt->getNieruchomosc()->getMiasto()->getNazwa() ?></td>
			<td><?=$grunt->getNieruchomosc()->getPowierzchnia() ?></td>
			<td><?=$grunt->getNieruchomosc()->getCena() ?></td>
			<td><?=$grunt->getPozwolenieNaBudowe() ?></td>
			<td><?=$grunt->getNieruchomosc()->pobierzKomunikacje() ?></td>
            <td><?=$grunt->getNieruchomosc()->pobierzDodatkowe() ?></td>
            <td>
				<a href="grunty.szczegoly.php?id=<?=$grunt->getId() ?>">szczegóły</a> |
				<a href="grunty.edycja.php?id=<?=$grunt->getId() ?>">edycja</a> |
				<a href="grunty.usun.php?id=<?=$grunt->getId() ?>">usuń</a>
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
