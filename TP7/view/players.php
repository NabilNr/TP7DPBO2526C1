<?php
require_once dirname(__DIR__) . '/class/Player.php';
require_once dirname(__DIR__) . '/class/Team.php';

$playerObj = new Player();
$teamObj = new Team();

if (isset($_POST['add_player'])) {
    $playerObj->create($_POST['name'], $_POST['position'], $_POST['team_id']);
    header("Location: index.php?page=players");
}

if (isset($_POST['update_player'])) {
    $playerObj->update($_POST['id'], $_POST['name'], $_POST['position'], $_POST['team_id']);
    header("Location: index.php?page=players");
}

if (isset($_GET['delete'])) {
    $playerObj->delete($_GET['delete']);
    header("Location: index.php?page=players");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = $playerObj->readById($_GET['edit']);
}

$players = $playerObj->readAll();
$teamsList = $teamObj->readAll()->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Manajemen Pemain Basket</h2>

<div class="form-container">
    <?php if ($editData): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <input type="text" name="name" value="<?= $editData['name'] ?>" required>
            <select name="position" required>
                <?php 
                $positions = ['Point Guard', 'Shooting Guard', 'Small Forward', 'Power Forward', 'Center'];
                foreach ($positions as $pos) {
                    $selected = ($pos == $editData['position']) ? 'selected' : '';
                    echo "<option value='$pos' $selected>$pos</option>";
                }
                ?>
            </select>
            <select name="team_id" required>
                <?php foreach ($teamsList as $t) { 
                    $selected = ($t['id'] == $editData['team_id']) ? 'selected' : '';
                ?>
                    <option value="<?= $t['id'] ?>" <?= $selected ?>><?= $t['name'] ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="update_player" style="background: #f0ad4e;">Update Pemain</button>
            <a href="index.php?page=players" class="btn-cancel">Batal</a>
        </form>
    <?php else: ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Nama Pemain" required>
            <select name="position" required>
                <option value="">Pilih Posisi</option>
                <option value="Point Guard">Point Guard</option>
                <option value="Shooting Guard">Shooting Guard</option>
                <option value="Small Forward">Small Forward</option>
                <option value="Power Forward">Power Forward</option>
                <option value="Center">Center</option>
            </select>
            <select name="team_id" required>
                <option value="">Pilih Tim</option>
                <?php foreach ($teamsList as $t) { ?>
                    <option value="<?= $t['id'] ?>"><?= $t['name'] ?></option>
                <?php } ?>
            </select>
            <button type="submit" name="add_player">Tambah Pemain</button>
        </form>
    <?php endif; ?>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Pemain</th>
        <th>Posisi</th>
        <th>Tim</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $players->fetch(PDO::FETCH_ASSOC)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['position'] ?></td>
        <td><?= $row['team_name'] ?: '<i>Tidak ada tim</i>' ?></td>
        <td>
            <a href="index.php?page=players&edit=<?= $row['id'] ?>" class="btn-edit">Edit</a>
            <a href="index.php?page=players&delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus pemain ini?')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>