<?php
	require_once 'bootstrap.php';
	require_once 'header.php';

//    $em->getConnection()
//        ->getConfiguration()
//        ->setSQLLogger(new \Doctrine\DBAL\Logging\DebugStack())
//    ;
    $query = $em->getRepository('Entity\Mieszkanie')->pobierzWszystko($_GET);
    $strona = (int)($_GET['strona'] ?? 0);

    $stronicowanie = new Model\Stronicowanie($query, $strona, 5);
    $mieszkania = $stronicowanie->pobierzDane();
    $linki = $stronicowanie->pobierzLinki();

    $miasta = $em->getRepository('Entity\Miasto')->pobierzSlownik();
    $typyOfert = ['S' => 'sprzedaż', 'W' => 'wynajem'];

?>
<form action="" method="get">

<table class="table table-stripped">
	<thead>
		<tr>
			<th>Id</th>
			<th>Typ</th>
			<th>Miasto</th>
			<th>Powierzchnia</th>
			<th>Cena</th>
			<th>Piętro</th>
			<th>Rok budowy</th>
			<th>Komunikacja</th>
            <th>Dodatkowe informacje</th>
			<th></th>
		</tr>
        <tr class="szukaj">
            <th></th>
            <th>
                <select name="typ_oferty" class="form-control form-control-sm">
                    <?php foreach ($typyOfert as $id => $nazwa) : ?>
                        <option value="<?= $id ?>" <?= ($_GET['typ_oferty'] ?? '') == $id ? 'selected' : '' ?>><?= $nazwa ?></option>
                    <?php endforeach; ?>
                </select>
            </th>
            <th>
                <select name="miasto" class="form-control form-control-sm">
                    <option value="">-</option>
                    <?php foreach ($miasta as $id => $nazwa) : ?>
                        <option value="<?= $id ?>" <?= ($_GET['miasto'] ?? '') == $id ? 'selected' : '' ?>><?= $nazwa ?></option>
                    <?php endforeach; ?>
                </select>
            </th>
            <th>
                od<input type="text" name="powierzchnia_od" value="<?= $_GET['powierzchnia_od'] ?? '' ?>" style="width: 90px;" class="form-control form-control-sm" />
                do<input type="text" name="powierzchnia_do" value="<?= $_GET['powierzchnia_do'] ?? '' ?>" style="width: 90px;" class="form-control form-control-sm" />

            </th>
            <th>
                od<input type="text" name="cena_od" value="<?= $_GET['cena_od'] ?? '' ?>" style="width: 90px;" class="form-control form-control-sm" />
                do<input type="text" name="cena_do" value="<?= $_GET['cena_do'] ?? '' ?>" style="width: 90px;" class="form-control form-control-sm" />
            </th>
            <th></th>
            <th>
                <input type="text" name="rok_budowy" value="<?= $_GET['rok_budowy'] ?? '' ?>" style="width: 90px;" class="form-control form-control-sm" />
            </th>
            <th></th>
            <th></th>
            <th><input type="submit" name="szukaj" value="Szukaj" class="btn btn-sm btn-primary" /></th>
        </tr>

    </thead>
	<tbody>
		<?php foreach ($mieszkania as $miesz): ?>
		<tr>
			<td><?=$miesz->getNieruchomosc()->getId() ?></td>
			<td><?=$miesz->getNieruchomosc()->getTypOferty() ?></td>
			<td><?=$miesz->getNieruchomosc()->getMiasto()->getNazwa() ?></td>
			<td><?=$miesz->getNieruchomosc()->getPowierzchnia() ?></td>
			<td><?=$miesz->getNieruchomosc()->getCena() ?></td>
			<td><?=$miesz->getPietro() ?>/<?=$miesz->getLiczbaPieter() ?></td>
			<td><?=$miesz->getRokBudowy() ?></td>
			<td><?=$miesz->getNieruchomosc()->pobierzKomunikacje() ?></td>
            <td><?=$miesz->getNieruchomosc()->pobierzDodatkowe() ?></td>
			<td>
				<a href="nieruchomosci.szczegoly.php?id=<?=$miesz->getId() ?>">szczegóły</a> |
				<a href="nieruchomosci.edycja.php?id=<?=$miesz->getId() ?>">edycja</a> |
				<a href="nieruchomosci.usun.php?id=<?=$miesz->getId() ?>">usuń</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
    <tfoot>
    <tr>
        <td colspan="9"><?= $linki ?></td>
    </tr>
    </tfoot>
</table>
</form>
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
