<?php

class DSNganh extends controller{
    private $dsnganh;
    
    function __construct()
    {
        $this->dsnganh = $this->model('Nganh_m');
    }

    // getdata de hien thi du lieu khi load trang
   // Trong controller
function Get_data() {
        $khoaList = $this->dsnganh->getKhoa();
        $this->view('Masterlayout_admin', [
        'page' => 'DSNganh_v',
        'dulieu' => $this->dsnganh->nganh_find('', ''),
        'khoaList' => $khoaList,
         // Truyền danh sách khoa vào view
    ]);
}
    function Timkiem(){
        if (isset($_POST['btnTimkiem'])) {
            $khoaList = $this->dsnganh->getKhoa();
            $maNganh = $_POST['txtTimkiemMaNganh'];
            $tenNganh = $_POST['txtTimkiemTenNganh'];
            
            $dl = $this->dsnganh->nganh_find($maNganh, $tenNganh);
            $this->view('Masterlayout_admin', [
                'page' => 'DSNganh_v',
                'dulieu' => $dl,
                'ma_nganh' => $maNganh,
                'ten_nganh' => $tenNganh,
                'khoaList' => $khoaList,
            ]);
        }   
    }





    function xoa($maNganh){
        $kq = $this->dsnganh->nganh_del($maNganh);
        if ($kq) {
            echo '<script>
                alert("Xóa thành công");
               window.location.href = "' . BASE_URL . 'DSNganh";
            </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    function sua($maNganh) {
        // Lấy danh sách khoa từ cơ sở dữ liệu
        $khoaList = $this->dsnganh->getKhoa(); // Lấy dữ liệu từ model
        
        $nganhData = $this->dsnganh->nganh_find($maNganh, "");
    
        // Truyền dữ liệu vào View
        $this->view('Masterlayout_admin', [
            'page' => 'Nganh_sua', 
            'dulieu' => $nganhData, // Thông tin ngành
            'khoaList' => $khoaList // Danh sách khoa
        ]);
    }
    
    
    

    function suadl(){
        if (isset($_POST['btnLuu'])) {
            $maNganh = $_POST['txtMaNganh'];
            $tenNganh = $_POST['txtTenNganh'];
            $maKhoa = $_POST['txtMaKhoa']; // Mã khoa
            $thoiGianDaoTao = $_POST['txtThoiGianDaoTao']; // Mã ngành
            $bacDaoTao = $_POST['txtBacDaoTao'];
            $kq = $this->dsnganh->nganh_upd($maNganh,$tenNganh, $maKhoa,$thoiGianDaoTao, $bacDaoTao);

            if ($kq) {
                echo '<script>
                    alert("Sửa thành công");
                   window.location.href = "' . BASE_URL . 'DSNganh";
                </script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }

            $this->view('Masterlayout_admin', [
                'page' => 'DSNganh_v',
                'dulieu' => $this->dsnganh->nganh_find('', '')
            ]);
        }
    }
}
?>
