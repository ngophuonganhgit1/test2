<?php

class DSGiangvien extends controller{
    private $dsgv;
    
    function __construct()
    {
        $this->dsgv = $this->model('Giangvien_m');
    }

    // getdata de hien thi du lieu khi load trang
    function Get_data() {
        $khoaList = $this->dsgv->getKhoa();  // Lấy dữ liệu khoa
        $this->view('Masterlayout_admin', [
            'page' => 'DSGiangvien_v',
            'dulieu' => $this->dsgv->giangvien_find('', ''),
            'khoaList' => $khoaList   // Truyền dữ liệu khoa vào view
        ]);
    }


    
    

    function Timkiem() {
        if (isset($_POST['btnTimkiem'])) {
            $maGV = $_POST['txtTimkiemMaGV'];
            $hoTen = $_POST['txtTimkiemHoTen'];
    
            $dl = $this->dsgv->giangvien_find($maGV, $hoTen);
            $khoaList = $this->dsgv->getKhoa();  // Lấy danh sách khoa
            $this->view('Masterlayout_admin', [
                'page' => 'DSGiangvien_v',
                'dulieu' => $dl,
                'ma_giang_vien' => $maGV,
                'ho_ten' => $hoTen,
                'khoaList' => $khoaList // Truyền danh sách khoa vào view
            ]);
        }
    }
    

    function xoa($maGV){
        $kq = $this->dsgv->giangvien_del($maGV);
        if ($kq) {
            echo '<script>
                alert("Xóa thành công");
                window.location.href = "' . BASE_URL . 'DSGiangvien";
            </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    function sua($maGV) {

        $khoaList = $this->dsgv->getKhoa(); // Lấy dữ liệu từ model
        
        // Kiểm tra xem có dữ liệu khoa hay không
        if (!$khoaList) {
            echo "Không có dữ liệu khoa!";
        } else {
            echo "Có dữ liệu khoa!";
        }
    
        // Lấy thông tin ngành dựa trên mã ngành
        $gvData = $this->dsgv->giangvien_find($maGV, "");
    
        $this->view('Masterlayout_admin', [
            'page' => 'Giangvien_sua',
            'dulieu' => $gvData,
            'khoaList' => $khoaList   // Truyền dữ liệu khoa vào view
        ]);
    }

    function suadl(){
        if (isset($_POST['btnLuu'])) {
            $maGV = $_POST['txtMaGV'];
            $maKhoa = $_POST['txtMaKhoa']; // Mã kho
            $hoTen = $_POST['txtHoTen'];
            $email = $_POST['txtEmail'];
            $soDienThoai = $_POST['txtSoDienThoai'];
            $chuyenNganh = $_POST['txtChuyenNganh'];

            $kq = $this->dsgv->giangvien_upd($maGV,$maKhoa,$hoTen, $email, $soDienThoai, $chuyenNganh);

            if ($kq) {
                echo '<script>
                    alert("Sửa thành công");
                    window.location.href = "' . BASE_URL . 'DSGiangvien";
                </script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            $this->view('Masterlayout_admin', [
                'page' => 'DSGiangvien_v',
                'dulieu' => $this->dsgv->giangvien_find('', '')
            ]);
        }
    }
}
?>
