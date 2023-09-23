<?php
session_start();
include "../../../../config/koneksi.php";

if ($_GET['act'] == "tambah") {
    $judul_buku = $_POST['judulBuku'];
    $kategori_buku = $_POST['kategoriBuku'];
    $penerbit_buku = $_POST['penerbitBuku'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahunTerbit'];
    $isbn = $_POST['iSbn'];
    $j_buku_baik = $_POST['jumlahBukuBaik'];
    $j_buku_rusak = $_POST['jumlahBukuRusak'];

    //query picture 
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $_FILES["gambarBuku"]["name"]);
      $extension = end($temp);
      $newName = date("Ymdhis").mt_rand(1262055681,1262055681).".png";

      if ((($_FILES["gambarBuku"]["type"] == "image/gif") || ($_FILES["gambarBuku"]["type"] == "image/jpeg") || ($_FILES["gambarBuku"]["type"] == "image/jpg") || ($_FILES["gambarBuku"]["type"] == "image/pjpeg") || ($_FILES["gambarBuku"]["type"] == "image/x-png") || ($_FILES["gambarBuku"]["type"] == "image/png")) && ($_FILES["gambarBuku"]["size"] < 2000000) && in_array($extension, $allowedExts))  {

        if ($_FILES["gambarBuku"]["error"] > 0) {
             header("location: " . $_SERVER['HTTP_REFERER']);
             $_SESSION['gagal'] = "Return Code: " . $_FILES["gambarBuku"]["error"];
        } else {

            if (file_exists("../../../../assets/dist/img/upload/" . $_FILES["gambarBuku"]["name"])) {
                header("location: " . $_SERVER['HTTP_REFERER']);
                $_SESSION['gagal'] = "Data gambar telah ada !";
            } else {
                if( move_uploaded_file($_FILES["gambarBuku"]["tmp_name"], "../../../../assets/dist/img/upload/" . $newName) ){
                    // PROCESS INSERT DATA TO DATABASE
                    $sql = "INSERT INTO buku(judul_buku,kategori_buku,penerbit_buku,pengarang,tahun_terbit,isbn,j_buku_baik,j_buku_rusak,image)
                        VALUES('" . $judul_buku . "','" . $kategori_buku . "','" . $penerbit_buku . "','" . $pengarang . "','" . $tahun_terbit . "','" . $isbn . "', '" . $j_buku_baik . "', '" . $j_buku_rusak . "', '" . $newName . "')";
                    $sql .= mysqli_query($koneksi, $sql);

                    if ($sql) {
                        $_SESSION['berhasil'] = "Data buku berhasil ditambahkan !";
                        header("location: " . $_SERVER['HTTP_REFERER']);
                    } else {
                        $_SESSION['gagal'] = "Data buku gagal ditambahkan !";
                        header("location: " . $_SERVER['HTTP_REFERER']);
                    }
                }else{
                    header("location: " . $_SERVER['HTTP_REFERER']);
                    $_SESSION['gagal'] = "Gambar gagal disimpan !";
                }
            }
        }
      } else {
        header("location: " . $_SERVER['HTTP_REFERER']);
        $_SESSION['gagal'] = "tipe ".$_FILES["gambarBuku"]["type"] . " file tidak memenuhi standar !";
      }

    
} elseif ($_GET['act'] == "edit") {
    $id_buku = $_POST['id_buku'];
    $judul_buku = $_POST['judulBuku'];
    $kategori_buku = $_POST['kategoriBuku'];
    $penerbit_buku = $_POST['penerbitBuku'];
    $pengarang = $_POST['pengarang'];
    $tahun_terbit = $_POST['tahunTerbit'];
    $isbn = $_POST['iSbn'];
    $j_buku_baik = $_POST['jumlahBukuBaik'];
    $j_buku_rusak = $_POST['jumlahBukuRusak'];
    $image = $_POST['gambarBukuEdit'];

    //query picture 
      $allowedExts = array("gif", "jpeg", "jpg", "png");
      $temp = explode(".", $_FILES["gambarBuku"]["name"]);
      $extension = end($temp);
      $newName = date("Ymdhis").mt_rand(1262055681,1262055681).".png";

      if($_FILES["gambarBuku"]["tmp_name"] == "")
        {
           $query = "UPDATE buku SET judul_buku = '$judul_buku', kategori_buku = '$kategori_buku', penerbit_buku = '$penerbit_buku', 
                                pengarang = '$pengarang', tahun_terbit = '$tahun_terbit', isbn = '$isbn', j_buku_baik = '$j_buku_baik', j_buku_rusak = '$j_buku_rusak', image = '$image'";

                    $query .= "WHERE id_buku = $id_buku";

                    $sql = mysqli_query($koneksi, $query);
                    if ($sql) {
                        $_SESSION['berhasil'] = "Data buku berhasil diedit !";
                        header("location: " . $_SERVER['HTTP_REFERER']);
                    } else {
                        $_SESSION['gagal'] = "Data buku gagal diedit !";
                        header("location: " . $_SERVER['HTTP_REFERER']);
                    }  
        }else
        {
             if ((($_FILES["gambarBuku"]["type"] == "image/gif") || ($_FILES["gambarBuku"]["type"] == "image/jpeg") || ($_FILES["gambarBuku"]["type"] == "image/jpg") || ($_FILES["gambarBuku"]["type"] == "image/pjpeg") || ($_FILES["gambarBuku"]["type"] == "image/x-png") || ($_FILES["gambarBuku"]["type"] == "image/png")) && ($_FILES["gambarBuku"]["size"] < 2000000) && in_array($extension, $allowedExts))  {

        if ($_FILES["gambarBuku"]["error"] > 0) {
             header("location: " . $_SERVER['HTTP_REFERER']);
             $_SESSION['gagal'] = "Return Code: " . $_FILES["gambarBuku"]["error"];
        } else {

            if (file_exists("../../../../assets/dist/img/upload/" . $_FILES["gambarBuku"]["name"])) {
                header("location: " . $_SERVER['HTTP_REFERER']);
                $_SESSION['gagal'] = "Data gambar telah ada !";
            } else {
                if( move_uploaded_file($_FILES["gambarBuku"]["tmp_name"], "../../../../assets/dist/img/upload/" . $newName) ){
                      // PROCESS EDIT DATA
                    $query = "UPDATE buku SET judul_buku = '$judul_buku', kategori_buku = '$kategori_buku', penerbit_buku = '$penerbit_buku', 
                                pengarang = '$pengarang', tahun_terbit = '$tahun_terbit', isbn = '$isbn', j_buku_baik = '$j_buku_baik', j_buku_rusak = '$j_buku_rusak', image = '$newName'";

                    $query .= "WHERE id_buku = $id_buku";

                    $sql = mysqli_query($koneksi, $query);
                    if ($sql) {
                        $_SESSION['berhasil'] = "Data buku berhasil diedit !";
                        header("location: " . $_SERVER['HTTP_REFERER']);
                    } else {
                        $_SESSION['gagal'] = "Data buku gagal diedit !";
                        header("location: " . $_SERVER['HTTP_REFERER']);
                    }
                }else{
                    header("location: " . $_SERVER['HTTP_REFERER']);
                    $_SESSION['gagal'] = "Gambar gagal disimpan !";
                }
            }
        }
      } else {
        header("location: " . $_SERVER['HTTP_REFERER']);
        $_SESSION['gagal'] = "tipe ".$_FILES["gambarBuku"]["type"] . " file tidak memenuhi standar !";
      }

        }
     
  
} elseif ($_GET['act'] == "hapus") {
    $id_buku = $_GET['id'];

    $sql = mysqli_query($koneksi, "DELETE FROM buku WHERE id_buku = '$id_buku'");

    if ($sql) {
        $_SESSION['berhasil'] = "Data buku berhasil di hapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    } else {
        $_SESSION['gagal'] = "Data buku gagal di hapus !";
        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
