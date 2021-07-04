<?php
require_once 'bootstrap.php';

$bledy = [];

if (!empty($_POST)) {
    // walidacja
    $v = new Valitron\Validator($_POST);
    $v->rule('required', [
        'nieruchomosc.typ_oferty', 'nieruchomosc.powierzchnia', 'nieruchomosc.cena', 'nieruchomosc.cena_m2', 'nieruchomosc.miasto',
        'pietro', 'liczba_pieter', 'rok_budowy'
    ]);
    $v->rule('numeric', ['nieruchomosc.powierzchnia', 'nieruchomosc.cena', 'nieruchomosc.cena_m2', 'pietro', 'liczba_pieter', 'rok_budowy']);
    $v->rule('min', 'rok_budowy', 1900);
    $v->rule('min', ['nieruchomosc.cena', 'nieruchomosc.cena_m2', 'nieruchomosc.powierzchnia'], 0);

    if ($v->validate()) {
        // ok
        $mieszkanie = new Entity\Mieszkanie();
        $hydrator = new Doctrine\Laminas\Hydrator\DoctrineObject($em);
        $hydrator->hydrate($_POST, $mieszkanie);

        $em->persist($mieszkanie);
        $em->flush();

        header('Location: index.php');
    } else {
        // błąd
        $bledy = $v->errors();
    }
}

$miasta = $em->getRepository('Entity\Miasto')->pobierzSlownik();
$opcjeKomunikacji = $em->getRepository('Entity\Komunikacja')->pobierzSlownik();
$typyOfert = ['S' => 'sprzedaż', 'W' => 'wynajem'];

require_once 'header.php';
?>

    <form method="post" action="" class="form">
        <div class="form-group">
            <label>Miasto</label>
            <select name="nieruchomosc[miasto]" class="form-control">
                <?php foreach ($miasta as $id => $nazwa): ?>
                    <option value="<?= $id ?>"
                        <?= ($id == ($_POST['nieruchomosc']['miasto'] ?? '')) ? 'selected' : '' ?>
                    ><?= $nazwa ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Typ oferty</label>
            <select name="nieruchomosc[typ_oferty]" class="form-control">
                <?php foreach ($typyOfert as $id => $nazwa): ?>
                    <option value="<?= $id ?>"
                        <?= ($id == ($_POST['nieruchomosc']['typ_oferty'] ?? '')) ? 'selected' : '' ?>
                    ><?= $nazwa ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Powierzchnia</label>
            <input
                    type="text"
                    name="nieruchomosc[powierzchnia]"
                    value="<?= $_POST['nieruchomosc']['powierzchnia'] ?? '' ?>"
                    class="form-control <?= empty($bledy['nieruchomosc.powierzchnia']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['nieruchomosc.powierzchnia'] ?? []) ?></div>
        </div>
        <div class="form-group">
            <label>Cena</label>
            <input
                    type="text"
                    name="nieruchomosc[cena]"
                    value="<?= $_POST['nieruchomosc']['cena'] ?? '' ?>"
                    class="form-control <?= empty($bledy['nieruchomosc.cena']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['nieruchomosc.cena'] ?? []) ?></div>
        </div>
        <div class="form-group">
            <label>Cena za m2</label>
            <input
                    type="text"
                    name="nieruchomosc[cena_m2]"
                    value="<?= $_POST['nieruchomosc']['cena_m2'] ?? '' ?>"
                    class="form-control <?= empty($bledy['nieruchomosc.cena_m2']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['nieruchomosc.cena_m2'] ?? []) ?></div>
        </div>

        <!-- dane mieszkania -->
        <div class="form-group">
            <label>Piętro</label>
            <input
                    type="text"
                    name="pietro"
                    value="<?= $_POST['pietro'] ?? '' ?>"
                    class="form-control <?= empty($bledy['pietro']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['pietro'] ?? []) ?></div>
        </div>
        <div class="form-group">
            <label>Liczba pięter</label>
            <input
                    type="text"
                    name="liczba_pieter"
                    value="<?= $_POST['liczba_pieter'] ?? '' ?>"
                    class="form-control <?= empty($bledy['liczba_pieter']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['liczba_pieter'] ?? []) ?></div>
        </div>
        <div class="form-group">
            <label>Rok budowy</label>
            <input
                    type="text"
                    name="rok_budowy"
                    value="<?= $_POST['rok_budowy'] ?? '' ?>"
                    class="form-control <?= empty($bledy['rok_budowy']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['rok_budowy'] ?? []) ?></div>
        </div>

        <div class="form-group">
            <label>Komunikacja</label>
            <?php foreach ($opcjeKomunikacji as $id => $nazwa): ?>
                <div class="form-check">
                    <input
                            class="form-check-input"
                            type="checkbox"
                            name="nieruchomosc[opcjekomunikacji][]"
                            value="<?= $id ?>"
                        <?= in_array($id, $_POST['nieruchomosc']['opcjekomunikacji'] ?? []) ? 'checked' : '' ?>
                    >
                    <label class="form-check-label">
                        <?= $nazwa ?>
                    </label>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" class="btn btn-primary">Dodaj</button>
    </form>

<?php require_once 'footer.php'; ?>