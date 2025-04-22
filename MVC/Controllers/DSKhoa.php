<?php

class DSKhoa extends controller{
    private $dskhoa;
    
    function __construct()
    {
        $this->dskhoa = $this->model('Khoa_m');
    }

    // getdata de hien thi du lieu khi load trang
    function Get_data(){
        $this->view('Masterlayout_admin', [
            'page' => 'DSKhoa_v',
            'dulieu' => $this->dskhoa->khoa_find('', '')
        ]);
    }


    
    

    function Timkiem(){
        if (isset($_POST['btnTimkiem'])) {
            $maKhoa = $_POST['txtTimkiemMaKhoa'];
            $tenKhoa = $_POST['txtTimkiemTenKhoa'];
            
            $dl = $this->dskhoa->khoa_find($maKhoa, $tenKhoa);
            $this->view('Masterlayout_admin', [
                'page' => 'DSKhoa_v',
                'dulieu' => $dl,
                'ma_Khoa' => $maKhoa,
                'ten_Khoa' => $tenKhoa
            ]);
        }   
    }
   
    




    function xoa($maKhoa){
        $kq = $this->dskhoa->khoa_del($maKhoa);
        if ($kq) {
            echo '<script>
                alert("Xóa thành công");
              window.location.href = "' . BASE_URL . 'DSKhoa";

            </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    function sua($maKhoa){
        $this->view('Masterlayout_admin', [
            'page' => 'Khoa_sua',
            'dulieu' => $this->dskhoa->khoa_find($maKhoa, "")
        ]);
    }

    function suadl(){
        if (isset($_POST['btnLuu'])) {
            $maKhoa = $_POST['txtMaKhoa'];
            $tenKhoa = $_POST['txtTenKhoa'];
            $lienHe = $_POST['txtLienHe']; // Mã khoa
            $ngayThanhLap = $_POST['txtNgayThanhLap']; // Mã ngành
            $tienMoiTinChi = $_POST['txtTienMoiTinChi'];
            $kq = $this->dskhoa->khoa_upd($maKhoa,$tenKhoa, $lienHe,$ngayThanhLap, $tienMoiTinChi);

            if ($kq) {
                echo '<script>
                    alert("Sửa thành công");
                   window.location.href = "' . BASE_URL . 'DSKhoa";

                </script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            $this->view('Masterlayout_admin', [
                'page' => 'DSKhoa_v',
                'dulieu' => $this->dskhoa->khoa_find('', '')
            ]);
        }
    }
}
?>