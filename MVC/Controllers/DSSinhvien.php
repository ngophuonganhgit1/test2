<?php

class DSSinhvien extends controller{
    private $dssv;
    
    function __construct()
    {
        $this->dssv = $this->model('Sinhvien_m');
    }

    // getdata de hien thi du lieu khi load trang
    function Get_data(){
        $khoaList = $this->dssv->getKhoa(); 
        $nganhList = $this->dssv->getNganh();
        $this->view('Masterlayout_admin', [
            'page' => 'DSSinhvien_v',
            'dulieu' => $this->dssv->sinhvien_find('', ''),
            'khoaList'=> $khoaList,
            'nganhList'=> $nganhList,
            
        ]);
    }


    
    

    function Timkiem(){
        if (isset($_POST['btnTimkiem'])) {
            $maSV = $_POST['txtTimkiemMaSV'];
            $hoTen = $_POST['txtTimkiemHoTen'];
            $khoaList = $this->dssv->getKhoa(); 
            $nganhList = $this->dssv->getNganh();
            
            $dl = $this->dssv->sinhvien_find($maSV, $hoTen);
            $this->view('Masterlayout_admin', [
                'page' => 'DSSinhvien_v',
                'dulieu' => $dl,
                'ma_sinh_vien' => $maSV,
                'ho_ten' => $hoTen,
                'khoaList'=> $khoaList,
                'nganhList'=> $nganhList,
                
            ]);
        }   
    }





    function xoa($maSV){
        $kq = $this->dssv->sinhvien_del($maSV);
        if ($kq) {
            echo '<script>
                alert("Xóa thành công");
               window.location.href = "' . BASE_URL . 'DSSinhvien";
            </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    function sua($maSV){
        $khoaList = $this->dssv->getKhoa(); 
        $nganhList = $this->dssv->getNganh(); 
    
        // Lấy thông tin ngành dựa trên mã ngành
        $svData = $this->dssv->sinhvien_find($maSV, "");

        $this->view('Masterlayout_admin', [
            'page' => 'Sinhvien_sua',
            'dulieu' =>$svData,
            'khoaList'=> $khoaList,
            'nganhList'=> $nganhList,

        ]);
    }

    function suadl(){
        if (isset($_POST['btnLuu'])) {
            $maSV = $_POST['txtMaSV'];
            $maKhoa = $_POST['txtMaKhoa']; // Mã khoa
            $maNganh = $_POST['txtMaNganh']; // Mã ngành
            $hoTen = $_POST['txtHoTen'];
            $ngaySinh = $_POST['txtNgaySinh'];
            $gioiTinh = $_POST['ddlGioiTinh'];
            $queQuan = $_POST['txtQueQuan'];
            $email = $_POST['txtEmail'];
            $soDienThoai = $_POST['txtSoDienThoai'];
            $khoaHoc = $_POST['txtKhoaHoc'];

            $kq = $this->dssv->sinhvien_upd($maSV,$maKhoa, $maNganh,$hoTen, $ngaySinh, $gioiTinh, $queQuan, $email, $soDienThoai, $khoaHoc);

            if ($kq) {
                echo '<script>
                    alert("Sửa thành công");
                   window.location.href = "' . BASE_URL . 'DSSinhvien";
                </script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            $this->view('Masterlayout_admin', [
                'page' => 'DSSinhvien_v',
                'dulieu' => $this->dssv->sinhvien_find('', '')
            ]);
        }
    }
}
?>
