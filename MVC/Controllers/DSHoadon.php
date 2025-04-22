<?php


class DSHoadon extends controller {
    private $dshd;

    function __construct() {
        $this->dshd = $this->model('Hoadon_m'); // Sử dụng model Hoadon_m thay vì Miengiam_m
    }

    // Lấy dữ liệu để hiển thị khi load trang
    function Get_data() {
        $dl = $this->dshd->searchHoaDon("", "");
        $this->view('Masterlayout_admin', [
            'page' => 'DSHoadon_v',
            'dulieu' => $dl, // Lấy danh sách hóa đơn
        ]);
    }

    // Thêm mới hóa đơn
    function themmoi() {
        if (isset($_POST['btnLuu'])) {
            // Lấy dữ liệu từ form
            $maSinhVien = $_POST['txtMasinhvien'];
            $maKhoanThu = $_POST['txtMakhoanthu'];
            $soTien = $_POST['txtSotien'];
            $ngayThanhToan = $_POST['txtNgaythanhtoan'];
            $noiDung = $_POST['txtNoidung'];  // Thêm nội dung vào đây
            $hinhThucThanhToan = $_POST['txtHinhthucthanhtoan']; // Thêm hình thức thanh toán
            
            // Thực hiện thêm mới hóa đơn vào cơ sở dữ liệu
            $kq = $this->dshd->hoadon_ins($maSinhVien, $maKhoanThu, $ngayThanhToan, $soTien, $hinhThucThanhToan, $noiDung);
    
            if ($kq) {
                // Cập nhật trạng thái thanh toán trong khoan_thu_sinh_vien
                $capnhatTrangThai = $this->dshd->capnhatTrangThaiThanhToan($maKhoanThu, $maSinhVien);
    
                if ($capnhatTrangThai) {
                    // Nếu thành công, thông báo và chuyển hướng
                    echo '<script>
                        alert("Thêm mới hóa đơn và cập nhật trạng thái thành công");
                        window.location.href = "' . BASE_URL . 'DSHoadon";
                    </script>';
                    exit();  // Dừng lại sau khi redirect
                } else {
                    echo '<script>alert("Thêm hóa đơn thành công nhưng cập nhật trạng thái thất bại")</script>';
                }
            } else {
                // Nếu thất bại, thông báo lỗi
                echo '<script>alert("Thêm mới hóa đơn thất bại")</script>';
            }
        } else {
            $tenkhoanthu=$this->dshd->getKhoanThuList();
            // Nếu chưa submit form, chỉ hiển thị form thêm mới
            $this->view('Masterlayout_admin', [
                'page' => 'Hoadon_them',  // Gọi view thêm mới hóa đơn
                'tenkhoanthu' => $tenkhoanthu,
            ]);
        }
    }
    

    // Tìm kiếm hóa đơn
    function Timkiem() {
        if (isset($_POST['btnTimkiem'])) {
            $maSinhVien = $_POST['txtTKMasinhvien'];
            $ngayThanhToan = $_POST['txtTKNgaythanhtoan']; // lấy dữ liệu từ form
            // $dulieu = $this->dshd->getHoaDonWithTenKhoanThu();
            // $dl = $this->dshd->hoadon_find($maSinhVien, $ngayThanhToan); // gọi hàm tìm kiếm
            // gọi lại giao diện render lại trang và truyền $dl ra
            $dl = $this->dshd->searchHoaDon($maSinhVien, $ngayThanhToan);
            $this->view('Masterlayout_admin', [
                'page' => 'DSHoadon_v',
                'dulieu' => $dl,
                'ma_sinh_vien' => $maSinhVien,
                'ngay_thanh_toan' => $ngayThanhToan,
            ]);
        }
    }

  

    // Hàm xóa
    function xoa($id) {
        // Lấy thông tin hóa đơn trước khi xóa
        $hoaDon = $this->dshd->getHoaDonById($id);
    
        if (!$hoaDon) {
            echo '<script>
                    alert("Hóa đơn không tồn tại!");
                    window.history.back();
                  </script>';
            exit;
        }
    
        $maKhoanThu = $hoaDon['ma_khoan_thu'];
        $maSinhVien = $hoaDon['ma_sinh_vien'];
    
        // Thực hiện xóa hóa đơn
        $kq = $this->dshd->hoadon_del($id);
    
        if ($kq) {
            // Cập nhật trạng thái thanh toán
            $this->dshd->capnhatTrangThaiThanhToan($maKhoanThu, $maSinhVien);
    
            echo '<script>
                    alert("Xóa thành công và trạng thái đã được cập nhật");
                   window.location.href = "' . BASE_URL . 'DSHoadon";
                  </script>';
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }
    
    function sua($id) {
        $tenkhoanthu=$this->dshd->getKhoanThuList();
        $this->view('Masterlayout_admin', [
            'page' => 'Hoadon_sua',
            'dulieu' => $this->dshd->idhoadon($id),
            'tenkhoanthu' => $tenkhoanthu,
        ]);
    }

    // Lưu dữ liệu sau khi sửa
    function suadl() {
        if (isset($_POST['btnLuu'])) {
            $id = $_POST['txtId'];
            $maSinhVien = $_POST['txtMasinhvien'];
            $maKhoanThu = $_POST['txtMakhoanthu'];
            $soTien = $_POST['txtSotien'];
            $ngayThanhToan = $_POST['txtNgaythanhtoan'];
            $noiDung = $_POST['txtNoidung'];  // Thêm nội dung vào đây
            $hinhThucThanhToan = $_POST['txtHinhthucthanhtoan']; // Thêm hình thức thanh toán

            // Thực hiện thêm mới hóa đơn vào cơ sở dữ liệu
            $kq = $this->dshd->hoadon_upd($id,$maSinhVien, $maKhoanThu, $ngayThanhToan, $soTien ,$hinhThucThanhToan, $noiDung);
            if ($kq) {
                echo '<script>alert("Sửa thành công")</script>';
            } else {
                echo '<script>alert("Sửa thất bại")</script>';
            }
            $dulieu = $this->dshd->getHoaDonWithTenKhoanThu();
            // Gọi lại giao diện
            $this->view('Masterlayout_admin', [
                'page' => 'DSHoadon_v',
                'dulieu' => $dulieu,
            ]);
        }
    }
}
