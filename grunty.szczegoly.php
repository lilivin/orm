<?php
	require_once 'bootstrap.php';
	require_once 'header.php';

//    $em->getConnection()
//        ->getConfiguration()
//        ->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack())
//    ;

	$grunt = $em->getRepository('Entity\Grunt')->find($_GET['id']);
	//dd($grunty);
	?>
<table class="table table-stripped">
	<tbody>

		<tr>
            <th>Id</th>
			<td><?=$grunt->getNieruchomosc()->getId() ?></td>
        </tr>
        <tr>
            <th>Typ</th>
            <td><?=$grunt->getNieruchomosc()->getTypOferty() ?></td>
        </tr>
        <tr>
            <th>Województwo</th>
            <td><?=$grunt->getNieruchomosc()->getMiasto()->getPowiat()->getWojewodztwo()->getNazwa() ?></td>
        </tr>
        <tr>
            <th>Powiat</th>
            <td><?=$grunt->getNieruchomosc()->getMiasto()->getPowiat()->getNazwa() ?></td>
        </tr>
        <tr>
            <th>Miasto</th>
            <td><?=$grunt->getNieruchomosc()->getMiasto()->getNazwa() ?></td>
        </tr>
        <tr>
            <th>Powierzchnia</th>
            <td><?=$grunt->getNieruchomosc()->getPowierzchnia() ?></td>
        </tr>
        <tr>
            <th>Cena</th>
			<td><?=$grunt->getNieruchomosc()->getCena() ?></td>
        </tr>
        <tr>
            <th>Cena za m2</th>
            <td><?=$grunt->getNieruchomosc()->getCenaM2() ?></td>
        </tr>
        <tr>
            <th>Pozwolenie na budowę</th>
            <td><?=$grunt->getPozwolenieNaBudowe() ?></td>
        </tr>
        <tr>
            <th>Komunikacja</th>
            <td><?=$grunt->getNieruchomosc()->pobierzKomunikacje() ?></td>
        </tr>
        <tr>
            <th>Dodatkowe informacje</th>
            <td><?=$grunt->getNieruchomosc()->pobierzDodatkowe() ?></td>
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
