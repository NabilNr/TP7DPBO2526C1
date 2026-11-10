<?php
require_once dirname(__DIR__) . '/class/MatchGame.php';
require_once dirname(__DIR__) . '/class/Team.php';

$matchObj = new MatchGame();
$teamObj = new Team();

if (isset($_POST['add_match'])) {
    $matchObj->create($_POST['match_date'], $_POST['home_team_id'], $_POST['away_team_id'], $_POST['score_home'], $_POST['score_away']);
    header("Location: index.php?page=matches");
}

if (isset($_POST['update_match'])) {
    $matchObj->update($_POST['id'], $_POST['match_date'], $_POST['home_team_id'], $_POST['away_team_id'], $_POST['score_home'], $_POST['score_away']);
    header("Location: index.php?page=matches");
}

if (isset($_GET['delete'])) {
    $matchObj->delete($_GET['delete']);
    header("Location: index.php?page=matches");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = $matchObj->readById($_GET['edit']);
}

$matches = $matchObj->readAll();
$teamsList = $teamObj->readAll()->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Jadwal & Hasil Pertandingan</h2>

<div class="form-container">
    <?php if ($editData): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <input type="date" name="match_date" value="<?= $editData['match_date'] ?>" required>
            
            <select name="home_team_id" required>
                <?php foreach ($teamsList as $t) { 
                    $selected = ($t['id'] == $editData['home_team_id']) ? 'selected' : '';
                ?>
                    <option value="<?= $t['id'] ?>" <?= $selected ?>><?= $t['name'] ?></option>
                <?php } ?>
            </select>
            <input type="number" name="score_home" value="<?= $editData['score_home'] ?>" required>
            
            <select name="away_team_id" required>
                <?php foreach ($teamsList as $t) { 
                    $selected = ($t['id'] == $editData['away_team_id']) ? 'selected' : '';
                ?>
                    <option value="<?= $t['id'] ?>" <?= $selected ?>><?= $t['name'] ?></option>
                <?php } ?>
            </select>
            <input type="number" name="score_away" value="<?= $editData['score_away'] ?>" required>

            <button type="submit" name="update_match" style="background: #f0ad4e;">Update Pertandingan</button>
            <a href="index.php?page=matches" class="btn-cancel">Batal</a>
        </form>
    <?php else: ?>
        <form method="POST">
            <input type="date" name="match_date" required>
            
            <select name="home_team_id" required>
                <option value="">Tim Tuan Rumah</option>
                <?php foreach ($teamsList as $t) { ?>
                    <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                <?php } ?>
            </select>
            <input type="number" name="score_home" placeholder="Skor Home" value="0" required>
            
            <select name="away_team_id" required>
                <option value="">Tim Tamu</option>
                <?php foreach ($teamsList as $t) { ?>
                    <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                <?php } ?>
            </select>
            <input type="number" name="score_away" placeholder="Skor Away" value="0" required>

            <button type="submit" name="add_match">Simpan Pertandingan</button>
        </form>
    <?php endif; ?>
</div>

<table>
    <tr>
        <th>Tanggal</th>
        <th>Tuan Rumah</th>
        <th>Skor</th>
        <th>Tim Tamu</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $matches->fetch(PDO::FETCH_ASSOC)) { ?>
    <tr>
        <td><?= $row['match_date'] ?></td>
        <td><?= $row['home_team'] ?></td>
        <td><strong><?= $row['score_home'] ?> - <?= $row['score_away'] ?></strong></td>
        <td><?= $row['away_team'] ?></td>
        <td>
            <a href="index.php?page=matches&edit=<?= $row['id'] ?>" class="btn-edit">Edit</a>
            <a href="index.php?page=matches&delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus pertandingan ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>