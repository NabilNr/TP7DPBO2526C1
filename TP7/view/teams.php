<?php
require_once dirname(__DIR__) . '/class/Team.php';
$teamObj = new Team();

if (isset($_POST['add_team'])) {
    $teamObj->create($_POST['name'], $_POST['city']);
    header("Location: index.php?page=teams");
}

if (isset($_POST['update_team'])) {
    $teamObj->update($_POST['id'], $_POST['name'], $_POST['city']);
    header("Location: index.php?page=teams");
}

if (isset($_GET['delete'])) {
    $teamObj->delete($_GET['delete']);
    header("Location: index.php?page=teams");
}

$editData = null;
if (isset($_GET['edit'])) {
    $editData = $teamObj->readById($_GET['edit']);
}

$teams = $teamObj->readAll();
?>

<h2>Manajemen Tim Basket</h2>

<div class="form-container">
    <?php if ($editData): ?>
        <form method="POST">
            <input type="hidden" name="id" value="<?= $editData['id'] ?>">
            <input type="text" name="name" value="<?= $editData['name'] ?>" required>
            <input type="text" name="city" value="<?= $editData['city'] ?>" required>
            <button type="submit" name="update_team" style="background: #f0ad4e;">Update Tim</button>
            <a href="index.php?page=teams" class="btn-cancel">Batal</a>
        </form>
    <?php else: ?>
        <form method="POST">
            <input type="text" name="name" placeholder="Nama Tim" required>
            <input type="text" name="city" placeholder="Asal Kota" required>
            <button type="submit" name="add_team">Tambah Tim</button>
        </form>
    <?php endif; ?>
</div>

<table>
    <tr>
        <th>ID</th>
        <th>Nama Tim</th>
        <th>Kota Asal</th>
        <th>Aksi</th>
    </tr>
    <?php while ($row = $teams->fetch(PDO::FETCH_ASSOC)) { ?>
    <tr>
        <td><?= $row['id'] ?></td>
        <td><?= $row['name'] ?></td>
        <td><?= $row['city'] ?></td>
        <td>
            <a href="index.php?page=teams&edit=<?= $row['id'] ?>" class="btn-edit">Edit</a>
            <a href="index.php?page=teams&delete=<?= $row['id'] ?>" class="btn-delete" onclick="return confirm('Hapus tim ini? Pemain terkait juga akan terhapus.')">Hapus</a>
        </td>
    </tr>
    <?php } ?>
</table>