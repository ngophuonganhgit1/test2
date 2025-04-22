<?php


class DSKhoanthu extends controller {
    private $dskt,$dsmg;

    function __construct() {
        $this->dskt = $this->model('Khoanthu_m');
        $this->dsmg = $this->model('Miengiam_m');
    }

    // Lấy dữ liệu để hiển thị khi load trang
    function Get_data() {
        $this->view('Masterlayout_admin', [
            'page' => 'DSKhoanthu_v',
            'dulieu' => $this->dskt->khoanthu_find('', ''),
        ]);
    }
    function themmoi() {
        if (isset($_POST['btnLuu'])) {
            // Lấy dữ liệu từ form
            $tenKhoanThu = $_POST['txtTenkhoanthu'];
            $loaiKhoanThu = $_POST['txtLoaikhoanthu'];
            $soTien = $_POST['txtSoTien'];
            $ngayTao = $_POST['txtNgaytao'];
            $hanNop = $_POST['txtHannop'];
            // kiểm tra điều kiện ngày
            if (strtotime($hanNop) < strtotime($ngayTao)) {
                echo '<script>
                    alert("Hạn nộp phải lớn hơn hoặc bằng ngày tạo!");
                   window.location.href = "' . BASE_URL . 'DSKhoanthu/themmoi";
                </script>';
                exit();
            }
            // Kiểm tra trùng tên khoản thu
            $kq1 = $this->dskt->checktrungkhoanthu($tenKhoanThu);
    
            if ($kq1) {
                echo '<script>
                    alert("Tên khoản thu đã tồn tại");
                   window.location.href = "' . BASE_URL . 'DSKhoanthu";
                </script>';
                exit(); // Dừng lại nếu tên khoản thu đã tồn tại
            } else {
                // BƯỚC 1: Tạo khoản thu chung
                $kq = $this->dskt->khoanthu_ins($tenKhoanThu, $loaiKhoanThu, $soTien, $ngayTao, $hanNop);
    
                if ($kq) {
                    // Lấy mã khoản thu vừa tạo
                    $maKhoanThu = mysqli_insert_id($this->dskt->con);
    
                    // BƯỚC 2: Xử lý theo loại khoản thu
                    if ($loaiKhoanThu === 'Học phí') {
                        // Nếu là học phí, tính học phí cho từng sinh viên
                        $resultHocPhi = $this->dskt->capNhatHocPhiChoSinhVien($maKhoanThu);
    
                        if (!$resultHocPhi) {
                            echo '<script>
                                alert("Thêm khoản thu thành công nhưng tính học phí thất bại!");
                               window.location.href = "' . BASE_URL . 'DSKhoanthu";
                            </script>';
                            exit();
                        }
                    } else {
                        // Nếu là khoản thu khác, gán mặc định cho từng sinh viên
                        $resultSinhVien = $this->dskt->khoanthu_sinhvien_ins($maKhoanThu, $soTien);
    
                        if (!$resultSinhVien) {
                            echo '<script>
                                alert("Thêm khoản thu thành công nhưng không có sinh viên nào để gán!");
                               window.location.href = "' . BASE_URL . 'DSKhoanthu";
                            </script>';
                            exit();
                        }
                    }
    
                    // BƯỚC 3: Cập nhật miễn giảm
                    $capnhatMienGiam = $this->dsmg->capnhatMienGiamKhiTaoKhoanThu($maKhoanThu);
    
                    if ($capnhatMienGiam) {
                        echo '<script>
                            alert("Thêm khoản thu, gán sinh viên và cập nhật miễn giảm thành công!");
                           window.location.href = "' . BASE_URL . 'DSKhoanthu";
                        </script>';
                    } else {
                        echo '<script>
                            alert("Thêm khoản thu thành công nhưng cập nhật miễn giảm thất bại!");
                           window.location.href = "' . BASE_URL . 'DSKhoanthu";
                        </script>';
                    }
                } else {
                    echo '<script>alert("Thêm mới khoản thu thất bại!")</script>';
                }
            }
        } else {
            // Hiển thị form thêm khoản thu
            $this->view('Masterlayout_admin', [
                'page' => 'Khoanthu_them', // Gọi view thêm khoản thu
            ]);
        }
    }
    
    
    
    
    

    // Tìm kiếm
    function Timkiem() {
        if (isset($_POST['btnTimkiem'])) {
            $tenKhoanThu = $_POST['txtTKTenkhoanthu'];
            $hanNop = $_POST['txtTKHannop']; // lấy dữ liệu từ form

            $dl = $this->dskt->khoanthu_find($tenKhoanThu, $hanNop); // gọi hàm tìm kiếm
            // gọi lại giao diện render lại trang và truyền $dl ra
            $this->view('Masterlayout_admin', [
                'page' => 'DSKhoanthu_v',
                'dulieu' => $dl,
                'ten_khoan_thu' => $tenKhoanThu,
                'han_nop' => $hanNop,
            ]);
        }
    }

    // Hàm upload Excel
   
    // Hàm xóa
    function xoa($id) {
        $kq = $this->dskt->khoanthu_del($id);
        if ($kq) {
            echo '<script>
                    alert("Xóa thành công");
                   window.location.href = "' . BASE_URL . 'DSKhoanthu";
                  </script>';
            exit();
        } else {
            echo '<script>alert("Xóa thất bại")</script>';
        }
    }

    // Hàm sửa
    function sua($id) {
        $this->view('Masterlayout_admin', [
            'page' => 'Khoanthu_sua',
            'dulieu' => $this->dskt->sua_id($id),
        ]);
    }

    // Lưu dữ liệu sau khi sửa
    function suadl() {
        if (isset($_POST['btnLuu'])) {
            $id = $_POST['txtId'];
            // $tenKhoanThu = $_POST['txtTenkhoanthu'];
            // $loaiKhoanThu = $_POST['txtLoaikhoanthu'];
            // $soTien = $_POST['txtSoTien'];
            $ngayTao = $_POST['txtNgaytao'];
            $hanNop = $_POST['txtHannop'];
            
            // kiểm tra điều kiện ngày
            if (strtotime($hanNop) < strtotime($ngayTao)) {
                echo '<script>
                    alert("Hạn nộp phải lớn hơn hoặc bằng ngày tạo!");
                   window.location.href = "' . BASE_URL . 'DSKhoanthu/suadl";
                </script>';
                exit();
            }
            // Cập nhật khoản thu
            $kq = $this->dskt->khoanthu_capnhathannop($id,$hanNop);
    
            if ($kq) {
                // Gọi hàm cập nhật miễn giảm cho sinh viên
                echo '<script>alert("Sửa khoản thu thành công!")</script>';
               
            } else {
                echo '<script>alert("Sửa khoản thu thất bại!")</script>';
            }
    
            // Gọi lại giao diện
            $this->view('Masterlayout_admin', [
                'page' => 'DSKhoanthu_v',
                'dulieu' => $this->dskt->khoanthu_find('', ''),
            ]);
        }
    }
    
}
?>
