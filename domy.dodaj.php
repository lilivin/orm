<?php
require_once 'bootstrap.php';

$bledy = [];

if (!empty($_POST)) {
    // walidacja
    $v = new Valitron\Validator($_POST);
    $v->rule('required', ['typ_oferty', 'powierzchnia', 'cena', 'cena_m2', 'miasto_id', 'powierzchnia_dzialki', 'rok_budowy']);
    $v->rule('numeric', ['powierzchnia', 'cena', 'cena_m2', 'powierzchnia_dzialki', 'rok_budowy']);
    $v->rule('min', 'rok_budowy', 1900);
    $v->rule('min', ['cena', 'cena_m2', 'powierzchnia', 'powierzchnia_dzialki'], 1);

    if ($v->validate()) {
        // ok

        // znajdź miasto
        $miasto = $em->find('Entity\Miasto', $_POST['miasto_id']);

        // zbuduj nieruchomość
        $nieruchomosc = new Entity\Nieruchomosc();
        $nieruchomosc->setTypOferty($_POST['typ_oferty']);
        $nieruchomosc->setPowierzchnia($_POST['powierzchnia']);
        $nieruchomosc->setCena($_POST['cena']);
        $nieruchomosc->setCenaM2($_POST['cena_m2']);
        $nieruchomosc->setMiasto($miasto);
        if (!empty($_POST['komunikacja_id'])) {
            foreach ($_POST['komunikacja_id'] as $idk) {
                $komunikacja = $em->find('Entity\Komunikacja', $idk);
                $nieruchomosc->addOpcjekomunikacji($komunikacja);
            }
        }

        // dodaj dom
        $dom = new Entity\Dom();
        $dom->setPowierzchniaDzialki($_POST['powierzchnia_dzialki']);
        $dom->setRokBudowy($_POST['rok_budowy']);
        $dom->setNieruchomosc($nieruchomosc);

        // ustaw powiązanie zwrotne
        $nieruchomosc->setDom($dom);
        $em->persist($nieruchomosc);
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
            <select name="miasto_id" class="form-control">
                <?php foreach ($miasta as $id => $nazwa): ?>
                    <option value="<?= $id ?>"
                        <?= ($id == ($_POST['miasto_id'] ?? '')) ? 'selected' : '' ?>
                    ><?= $nazwa ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Typ oferty</label>
            <select name="typ_oferty" class="form-control">
                <?php foreach ($typyOfert as $id => $nazwa): ?>
                    <option value="<?= $id ?>"
                        <?= ($id == ($_POST['typ_oferty'] ?? '')) ? 'selected' : '' ?>
                    ><?= $nazwa ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Powierzchnia</label>
            <input
                    type="text"
                    name="powierzchnia"
                    value="<?= $_POST['powierzchnia'] ?? '' ?>"
                    class="form-control <?= empty($bledy['powierzchnia']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['powierzchnia'] ?? []) ?></div>
        </div>
        <div class="form-group">
            <label>Cena</label>
            <input
                    type="text"
                    name="cena"
                    value="<?= $_POST['cena'] ?? '' ?>"
                    class="form-control <?= empty($bledy['cena']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['cena'] ?? []) ?></div>
        </div>
        <div class="form-group">
            <label>Cena za m2</label>
            <input
                    type="text"
                    name="cena_m2"
                    value="<?= $_POST['cena_m2'] ?? '' ?>"
                    class="form-control <?= empty($bledy['cena_m2']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['cena_m2'] ?? []) ?></div>
        </div>

        <!-- dane domu -->
        <div class="form-group">
            <label>Powierzchnia działki</label>
            <input
                    type="text"
                    name="powierzchnia_dzialki"
                    value="<?= $_POST['powierzchnia_dzialki'] ?? '' ?>"
                    class="form-control <?= empty($bledy['powierzchnia_dzialki']) ?: 'is-invalid' ?>"
            />
            <div class="invalid-feedback"><?= implode('<br>', $bledy['powierzchnia_dzialki'] ?? []) ?></div>
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
                            name="komunikacja_id[]"
                            value="<?= $id ?>"
                        <?= in_array($id, $_POST['komunikacja_id'] ?? []) ? 'checked' : '' ?>
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