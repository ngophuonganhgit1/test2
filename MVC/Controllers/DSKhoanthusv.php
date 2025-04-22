<?php


class DSKhoanthusv extends controller {
    private $dskt;

    function __construct() {
        $this->dskt = $this->model('Khoanthusv_m'); // Model dành cho khoản thu sinh viên
    }

    // Lấy dữ liệu để hiển thị khi load trang
    function Get_data() {
        $this->view('Masterlayout_admin', [
            'page' => 'DSKhoanthusv_v',
            'dulieu' => $this->dskt->hienthidl("","",""),
        ]);
    }

    // Thêm mới khoản thu sinh viên
    function themmoi() {
        if (isset($_POST['btnLuu'])) {
            $maKhoanThu= $_POST['txtId'];
            $maSinhVien = $_POST['txtMaSV'];
            $soTienBanDau = $_POST['txtSoTienBanDau'];
            $soTienMienGiam = $_POST['txtSoTienMienGiam'];
            $soTienPhaiNop = $_POST['txtSoTienPhaiNop'];
           
            $trangThaiThanhToan = $_POST['txtTrangThaiThanhToan'];

            $kq1 = $this->dskt->checktrungkhoanthu($maSinhVien);

            if ($kq1) {
                echo '<script>
                    alert("Khoản thu đã tồn tại");
                   window.location.href = "' . BASE_URL . 'DSKhoanthusv";
                    </script>';
                exit();
            } else {
                $kq = $this->dskt->khoanthu_ins($maKhoanThu,$maSinhVien, $soTienBanDau, $soTienMienGiam, $soTienPhaiNop, $trangThaiThanhToan);

                if ($kq) {
                    echo '<script>
                        alert("Thêm mới khoản thu thành công");
                       window.location.href = "' . BASE_URL . 'DSKhoanthusv";
                    </script>';
                    exit();
                } else {
                    echo '<script>alert("Thêm mới khoản thu thất bại")</script>';
                }
            }
        } else {
            $this->view('Masterlayout_admin', [
                'page' => 'Khoanthusv_them',
            ]);
        }
    }

    // Tìm kiếm
    function Timkiem() {
        if (isset($_POST['btnTimkiem'])) {
            $maSinhVien = $_POST['txtTKMaSV'];
            $trangThaiThanhToan = $_POST['txtTKTrangThai'];
            $tenKhoanThu = $_POST['txtTKTenKhoanThu'];

            $dl = $this->dskt->hienthidl($maSinhVien,$tenKhoanThu, $trangThaiThanhToan);

            $this->view('Masterlayout_admin', [
                'page' => 'DSKhoanthusv_v',
                'dulieu' => $dl,
                'ma_sinh_vien' => $maSinhVien,
                'trang_thai_thanh_toan' => $trangThaiThanhToan,
                'ten_khoan_thu' => $tenKhoanThu,
            ]);
        }
    }

  

    // Xóa khoản thu
    function xoa() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ POST
            $maKhoanThu = $_POST['ma_khoan_thu'];
            $maSinhVien = $_POST['ma_sinh_vien'];
    
            // Gọi model để xóa bản ghi
            $kq = $this->dskt->khoanthu_del($maKhoanThu, $maSinhVien);
    
            if ($kq) {
                echo '<script>
                        alert("Xóa thành công");
                       window.location.href = "' . BASE_URL . 'DSKhoanthusv";
                      </script>';
                exit();
            } else {
                echo '<script>alert("Xóa thất bại")</script>';
            }
        } else {
            echo '<script>alert("Phương thức không hợp lệ!")</script>';
            header('Location: <?php echo BASE_URL; ?>DSKhoanthusv');
            exit();
        }
    }
    

    // Sửa khoản thu
    function sua() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ POST
            $maKhoanThu = $_POST['ma_khoan_thu'];
            $maSinhVien = $_POST['ma_sinh_vien'];
    
            // Gọi view và truyền dữ liệu từ model
            $this->view('Masterlayout_admin', [
                'page' => 'Khoanthusv_sua',
                'dulieu' => $this->dskt->sua_id($maKhoanThu, $maSinhVien),
            ]);
        } else {
            echo '<script>alert("Phương thức không hợp lệ!");</script>';
            header('Location: <?php echo BASE_URL; ?>DSKhoanthusv');
            exit();
        }
    }
    

    // Lưu dữ liệu sau khi sửa
    function suadl() {
        if (isset($_POST['btnLuu'])) {
            $id = $_POST['txtId'];
            $maSinhVien = $_POST['txtMaSV'];
            $soTienBanDau = $_POST['txtSoTienBanDau'];
            $soTienMienGiam = $_POST['txtSoTienMienGiam'];
            $soTienPhaiNop = $_POST['txtSoTienPhaiNop'];
            $trangThaiThanhToan = $_POST['txtTrangThaiThanhToan'];

            $kq = $this->dskt->khoanthu_upd($id, $maSinhVien, $soTienBanDau, $soTienMienGiam, $soTienPhaiNop, $trangThaiThanhToan);
            if ($kq) {
                echo '<script>alert("Sửa thành công")</script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            $this->view('Masterlayout_admin', [
                'page' => 'DSKhoanthusv_v',
                'dulieu' => $this->dskt->khoanthu_find('', ''),
            ]);
        }
    }
}
?>
