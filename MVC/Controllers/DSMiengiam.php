<?php


class DSMiengiam extends controller {
    private $dsmg;

    function __construct() {
        $this->dsmg = $this->model('Miengiam_m');
    }

    // Lấy dữ liệu để hiển thị khi load trang
    function Get_data() {
        
        
        $this->view('Masterlayout_admin', [
            'page' => 'DSMiengiam_v',
            'dulieu' => $this->dsmg->miengiam_find('', ''),
            
        ]);
    }

    // Thêm mới miễn giảm
    function themmoi() {
        if (isset($_POST['btnLuu'])) {
            // Lấy dữ liệu từ form
            $maSinhVien = $_POST['txtMasinhvien'];
            $mucTien = $_POST['txtMuctien'];
            $loaiMienGiam = $_POST['txtLoaimiengiam'];
            $ghiChu = $_POST['txtGhichu'];
           
            

            // Kiểm tra trùng mã sinh viên và loại miễn giảm
            $kq1 = $this->dsmg->checktrungmiengiam($maSinhVien, $loaiMienGiam);

            if ($kq1) {
                // Nếu trùng, thông báo lỗi
                echo '<script>
                    alert("Mã sinh viên và loại miễn giảm đã tồn tại");
                   window.location.href = "' . BASE_URL . 'DSMiengiam";
                    </script>';
                exit();  // Dừng lại ngay sau khi thông báo lỗi
            } else {
                // Thực hiện thêm mới miễn giảm vào cơ sở dữ liệu
                $kq = $this->dsmg->miengiam_ins($maSinhVien, $mucTien, $loaiMienGiam,$ghiChu);

                if ($kq) {
                    // Nếu thành công, thông báo và chuyển hướng
                    echo '<script>
                        alert("Thêm mới miễn giảm thành công");
                       window.location.href = "' . BASE_URL . 'DSMiengiam";
                    </script>';
                    exit();  // Dừng lại sau khi redirect
                } else {
                    // Nếu thất bại, thông báo lỗi
                    echo '<script>alert("Thêm mới miễn giảm thất bại")</script>';
                }
            }
        } else {
            $dsloaikhoanthu=$this->dsmg->getAllLoaiKhoanThu();
            // Nếu chưa submit form, chỉ hiển thị form thêm mới
            $this->view('Masterlayout_admin', [
                'page' => 'Miengiam_them',
                'dsloaikhoanthu' => $dsloaikhoanthu,  // Gọi view thêm mới miễn giảm
            ]);
        }
    }

    // Tìm kiếm miễn giảm
    function Timkiem() {
        if (isset($_POST['btnTimkiem'])) {
            $maSinhVien = $_POST['txtTKMasinhvien'];
            $loaiMienGiam = $_POST['txtTKLoaimiengiam']; // lấy dữ liệu từ form

            $dl = $this->dsmg->miengiam_find($maSinhVien, $loaiMienGiam); // gọi hàm tìm kiếm
            // gọi lại giao diện render lại trang và truyền $dl ra
            $this->view('Masterlayout_admin', [
                'page' => 'DSMiengiam_v',
                'dulieu' => $dl,
                'ma_sinh_vien' => $maSinhVien,
                'loai_mien_giam' => $loaiMienGiam,
            ]);
        }
    }


    // Hàm xóa
    function xoa($id) {
        $kq = $this->dsmg->miengiam_del($id);
        if ($kq) {
            echo '<script>
                    alert("Xóa thành công");
                   window.location.href = "' . BASE_URL . 'DSMiengiam";
                  </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    // Hàm sửa
    function sua($id) {
        $dsloaikhoanthu=$this->dsmg->getAllLoaiKhoanThu();
        $this->view('Masterlayout_admin', [
            'page' => 'Miengiam_sua',
            'dulieu' => $this->dsmg->idmiengiam($id),
            'dsloaikhoanthu' => $dsloaikhoanthu,
        ]);
    }

    // Lưu dữ liệu sau khi sửa
    function suadl() {
        if (isset($_POST['btnLuu'])) {
            $id = $_POST['txtId'];
            $maSinhVien = $_POST['txtMasinhvien'];
            $loaiMienGiam = $_POST['txtLoaimiengiam'];
            $mucTien = $_POST['txtMuctien'];
            $ghiChu = $_POST['txtGhichu'];
          
            $kq = $this->dsmg->miengiam_upd($id, $maSinhVien, $mucTien,$loaiMienGiam,$ghiChu);
            if ($kq) {
                echo '<script>alert("Sửa thành công")</script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            // Gọi lại giao diện
            $this->view('Masterlayout_admin', [
                'page' => 'DSMiengiam_v',
                'dulieu' => $this->dsmg->miengiam_find('', ''),
            ]);
        }
    }
}
?>
