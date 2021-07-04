<?php
require_once 'bootstrap.php';

$bledy = [];

if (!empty($_POST)) {
    // walidacja
    $v = new Valitron\Validator($_POST);
    $v->rule('required', ['typ_oferty', 'powierzchnia', 'cena', 'cena_m2', 'miasto_id', 'pozwolenie']);
    $v->rule('numeric', ['powierzchnia', 'cena', 'cena_m2']);
    $v->rule('min', ['cena', 'cena_m2', 'powierzchnia'], 1);

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

        // dodaj grunt
        $grunt = new Entity\Grunt();
        $grunt->setPozwolenieNaBudowe($_POST['pozwolenie']);
        $grunt->setNieruchomosc($nieruchomosc);

        // ustaw powiązanie zwrotne
        $nieruchomosc->setGrunt($grunt);

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

        <!-- dane gruntu -->
        <div class="form-group">
            <label>Pozwolenie na budowę</label>
            <select name="pozwolenie" class="form-control">
                <option value="Tak"
                    <?= ("Tak" == ($_POST['pozwolenie'] ?? '')) ? 'selected' : '' ?>
                >Tak
                </option>
                <option value="Nie"
                    <?= ("Nie" == ($_POST['pozwolenie'] ?? '')) ? 'selected' : '' ?>
                >Nie
                </option>
            </select>
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