<?php 
include 'koneksi.php';

if(!isset($_SESSION['login']) || $_SESSION['role'] != "guru"){
    header("location:beranda.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Input Kehadiran Guru - MTs Bone Bolango</title>

<style>
    /* === STYLE GLOBAL (SAMA DENGAN LOGIN) === */
body {
    font-family: "Poppins", sans-serif;
    background: linear-gradient(1deg, #152f32ff, #c4e0e5);
    min-height: 100vh;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* === CARD CONTAINER === */
.container {
    background-color: #ffffff;
    border-radius: 12px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    width: 420px;
    padding: 40px 30px;
    position: relative;
}

/* === LOGO BULAT === */
.logo {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #4ca1af;
}

/* === JUDUL === */
h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
    font-weight: 600;
}

h3 {
    text-align: center;
    margin-top: 0;
    color: #4ca1af;
    font-size: 18px;
    font-weight: 500;
}

/* === FORM INPUT === */
form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

input[type="text"],
input[type="time"],
input[type="number"] {
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 15px;
    transition: 0.2s ease;
}

input:focus {
    border-color: #4ca1af;
    outline: none;
    box-shadow: 0 0 6px rgba(76, 161, 175, 0.4);
}

/* === TOMBOL === */
button {
    background-color: #4ca1af;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 12px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.25s ease;
}

button:hover {
    background-color: #3a8794;
}


.logout {
    margin-top: 1px;
    display: inline-block;
  
    text-align: center;
    padding: 12px 10px;
    background: #152f32;
    color: white;
    border-radius: 10px;
    text-decoration: none;
    transition: 0.25s ease;
    font-size: 14px;
    margin-left: 0x;
    margin-right: 0px;

}

.logout:hover {
    background: #0f2426;
}


.popup {
    display: none;
    text-align: center;
    padding: 30px 20px;
    background-color: #f8ffff;
    border: 2px solid #4ca1af;
    border-radius: 10px;
    box-shadow: 0 6px 20px rgba(0,0,0,0.2);
}

.popup.show {
    display: block;
    animation: fadeIn 0.4s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

/* === MODAL BACKGROUND === */
#rekapModal {
    display:none;
    position:fixed;
    top:0; left:0; width:100%; height:100%;
    background:rgba(0,0,0,0.4);
    padding-top:60px;
    z-index:9999;
}

/* === MODAL BOX === */
#rekapContent {
    background:white;
    margin:auto;
    padding:20px;
    width:85%;
    max-width:800px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.3);
    position:relative;
}

/* === TABEL === */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

table th {
    background: #4ca1af;
    color: white;
    padding: 8px;
}

table td {
    padding: 8px;
    border: 1px solid #ccc;
}

/* === FOOTER === */
.footer-text {
    text-align: center;
    margin-top: 20px;
    font-size: 13px;
    color: #555;
}

</style>

</head>
<body>

<div class="container">

    <img src="mts.png" class="logo">
    <h3>Halo, <?= $_SESSION['nama'] ?> (Guru)</h3>
    <h2>Input Kehadiran Guru</h2>

    <form method="POST" id="absenForm">
        <input type="text" name="nama_guru" placeholder="Nama Guru" required>
        <input type="text" name="kelas" placeholder="Kelas" required>
        <input type="text" name="mata_pelajaran" placeholder="Mata Pelajaran" required>
        <input type="time" name="jam" required>
        <input type="number" name="pertemuan" placeholder="Pertemuan ke-" required>

        <button name="submit">Simpan</button>
        <a href="logout.php" class="logout">Logout</a>
    </form>

   
    <div class="popup" id="popupSukses">
        <h2>Absen Berhasil!</h2>
        <p>Data kehadiran telah disimpan ke sistem.</p>

        <div style="display:flex; gap:10px; justify-content:center;">
            <button onclick="window.location.href='index.php'">Input Lagi</button>

            <button style="background:#2e8b57;"
                    onclick="document.getElementById('rekapModal').style.display='block'">
                Lihat Rekapan
            </button>
        </div>
    </div>

</div> 

<div id="rekapModal">
    <div id="rekapContent">

        <button onclick="document.getElementById('rekapModal').style.display='none'"
                style="position:absolute; top:10px; right:10px;
                       background:#d9534f; color:white; border:none;
                       padding:6px 12px; border-radius:6px; cursor:pointer;">
            X
        </button>

        <h2 style="text-align:center; color:#4ca1af;">Rekapan Absen</h2>

       
        <form method="GET" style="margin-bottom:15px;">
            <div style="display:flex; gap:10px; flex-wrap:wrap; justify-content:center;">
                <input type="date" name="tanggal" value="<?= $_GET['tanggal'] ?? '' ?>"
                       style="padding:8px; border-radius:6px; border:1px solid #aaa;">

                <input type="text" name="kelas" placeholder="Kelas" 
                       value="<?= $_GET['kelas'] ?? '' ?>"
                       style="padding:8px; border-radius:6px; border:1px solid #aaa;">

                <input type="text" name="mapel" placeholder="Mapel" 
                       value="<?= $_GET['mapel'] ?? '' ?>"
                       style="padding:8px; border-radius:6px; border:1px solid #aaa;">

                <button type="submit"
                        style="padding:8px 14px; background:#4ca1af; color:white;
                               border:none; border-radius:6px; cursor:pointer;">
                    Filter
                </button>
            </div>
        </form>

      
        <table>
            <tr>
                <th>No</th>
                <th>Kelas</th>
                <th>Mapel</th>
                <th>Jam</th>
                <th>Pert.</th>
                <th>Tanggal</th>
            </tr>

            <?php
            $id_user = $_SESSION['id_user'];
            $query = "SELECT * FROM absen_guru WHERE id_user='$id_user'";

            if (!empty($_GET['tanggal'])) $query .= " AND tanggal='".$_GET['tanggal']."'";
            if (!empty($_GET['kelas']))   $query .= " AND kelas='".$_GET['kelas']."'";
            if (!empty($_GET['mapel']))   $query .= " AND mata_pelajaran='".$_GET['mapel']."'";

            $query .= " ORDER BY id_absen DESC";

            $data = mysqli_query($conn, $query);
            $no = 1;

            while ($row = mysqli_fetch_assoc($data)) {
                echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['kelas']}</td>
                        <td>{$row['mata_pelajaran']}</td>
                        <td>{$row['jam']}</td>
                        <td>{$row['pertemuan']}</td>
                        <td>{$row['tanggal']}</td>
                    </tr>";
                $no++;
            }
            ?>

        </table>

    </div>
</div>


<?php
if(isset($_POST['submit'])){
    $id_user = $_SESSION['id_user'];
    $nama_guru = $_POST['nama_guru'];
    $kelas = $_POST['kelas'];
    $mapel = $_POST['mata_pelajaran'];
    $jam = $_POST['jam'];
    $pertemuan = $_POST['pertemuan'];

    $query = "INSERT INTO absen_guru (id_user, nama_guru, kelas, mata_pelajaran, jam, pertemuan, tanggal)
              VALUES ('$id_user', '$nama_guru', '$kelas', '$mapel', '$jam', '$pertemuan', CURRENT_DATE)";

    if(mysqli_query($conn, $query)){
        echo "<script>
            document.addEventListener('DOMContentLoaded', function(){
                document.getElementById('absenForm').style.display='none';
                document.getElementById('popupSukses').classList.add('show');
            });
        </script>";
    }
}
?>
<?php if(!isset($_GET['sukses']) && (isset($_GET['tanggal']) || isset($_GET['kelas']) || isset($_GET['mapel'])))
 { ?>
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.getElementById('rekapModal').style.display = 'block';
    });
</script>
<?php } ?>



</body>
</html>
