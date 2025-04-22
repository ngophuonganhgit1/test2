<?php

class dsmonhoc extends controller {
    private $dsmonhoc;

    function __construct() {
        $this->dsmonhoc = $this->model('monhoc_m');
    }

    // Hiển thị dữ liệu khi tải trang
    function Get_data() {
        $this->view('Masterlayout_admin', [
            'page' => 'dsmonhoc_v',
            'dulieu' => $this->dsmonhoc->monhoc_find('', '')
        ]);
    }

    // Tìm kiếm môn học
    function Timkiem() {
        if (isset($_POST['btnTimkiem'])) {
            $ma_mon = $_POST['txtTKMaMon'];
            $ten_mon = $_POST['txtTKTenMon'];
            
            $dl = $this->dsmonhoc->monhoc_find($ma_mon, $ten_mon); // Gọi hàm tìm kiếm
            $this->view('Masterlayout_admin', [
                'page' => 'dsmonhoc_v',
                'dulieu' => $dl,
                'ma_mon' => $ma_mon,
                'ten_mon' => $ten_mon
            ]);
        }
    }

    // Upload dữ liệu từ file Excel
    // Xóa môn học
    function xoa($ma_mon) {
        $kq = $this->dsmonhoc->monhoc_del($ma_mon);
        if ($kq) {
            echo '<script>
                    alert("Xóa thành công");
                   window.location.href = "' . BASE_URL . 'dsmonhoc";
                  </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    // Hiển thị giao diện sửa môn học
    function sua($ma_mon){
        $this->view('Masterlayout_admin',[
            'page'=>'monhoc_sua',
            'dulieu'=>$this->dsmonhoc->monhoc_find($ma_mon,"")
        ]);
    }

    // Lưu thông tin sửa môn học
    function suadl() {
        if (isset($_POST['btnLuu'])) {
            $ma_mon = $_POST['txtMaMon'];
            $ten_mon = $_POST['txtTenMon'];
            $ma_nganh= $_POST['txtMaNganh'];
            $so_tin_chi = $_POST['txtSoTinChi'];
            $so_tiet = $_POST['txtSoTiet'];
            $kq = $this->dsmonhoc->monhoc_upd($ma_mon,$ten_mon, $ma_nganh, $so_tin_chi, $so_tiet);
            if ($kq) {
                echo '<script>alert("Sửa thành công")</script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            $this->view('Masterlayout_admin', [
                'page' => 'dsmonhoc_v',
                'dulieu' => $this->dsmonhoc->monhoc_find('', '')
            ]);
        }
    }
}
?>
