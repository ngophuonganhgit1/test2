<?php


class DSdiemtungmon_gv extends controller {
    private $diemtungmon;

    function __construct() {
        $this->diemtungmon = $this->model('DSdiemtheomon_m');
    }

    // Hiển thị danh sách lớp và điểm chi tiết
    function Get_data() {
        // Lấy mã giảng viên từ session
        $ma_giang_vien = $_SESSION['ma_tai_khoan'];

        // Lấy mã lớp được chọn từ POST hoặc GET
        $selected_class_id = isset($_POST['class_id']) ? $_POST['class_id'] : (isset($_GET['class_id']) ? $_GET['class_id'] : null);
        // Lấy giá trị tìm kiếm từ form
        $ma_sinh_vien = isset($_POST['txtTimkiemMaSV']) ? $_POST['txtTimkiemMaSV'] : null;
        $ho_ten = isset($_POST['txtTimkiemHoTen']) ? $_POST['txtTimkiemHoTen'] : null;
        

        // Truyền trực tiếp kết quả của các phương thức vào view
        $this->view('Masterlayout_gv', [
            'page' => 'DSdiem_gv',
            'classes' => $this->diemtungmon->getClassesByLecturer($ma_giang_vien), // Truyền danh sách lớp vào view
            // 'dulieu' => $selected_class_id ? $this->diemtungmon->getStudentScoresByClass($selected_class_id) : null // Truyền danh sách điểm nếu đã chọn lớp
            'dulieu' => $selected_class_id ? 
                $this->diemtungmon->diemtungmon_find($selected_class_id, $ma_sinh_vien, $ho_ten) : null // Truyền danh sách điểm nếu đã chọn lớp và có tìm kiếm
        ]);
    }

    
    

    // Hiển thị form sửa điểm chi tiết
    function sua($id) {
        // Lấy dữ liệu theo ID để hiển thị trong form sửa
        $dulieu = $this->diemtungmon->diemtungmon_find_madct($id);

        // Kiểm tra nếu không tìm thấy dữ liệu
        if (!$dulieu || mysqli_num_rows($dulieu) == 0) {
            echo '<script>
            alert("Dữ liệu không tồn tại");
            window.location.href = "' . BASE_URL . 'DSdiemtungmon_gv/Get_data";
        </script>';

            exit;
        }

        $class_id = isset($_POST['class_id']) ? $_POST['class_id'] : '';

        // Trả về view sửa điểm chi tiết với dữ liệu
        $this->view('Masterlayout_gv', [
            'page' => 'DSdiemchitiet_sua',
            'dulieu' => $dulieu,
            'class_id' => $class_id
        ]);
    }

    // Xử lý cập nhật điểm chi tiết
    function suadl() {
        if (isset($_POST['btnLuu'])) {
            // Lấy dữ liệu từ form
            $id = $_POST['txtId'];
            $lan_hoc = $_POST['txtLanHoc'];
            $lan_thi = $_POST['txtLanThi'];
            $diem_chuyen_can = $_POST['txtDiemChuyenCan'];
            $diem_giua_ky = $_POST['txtDiemGiuaKy'];
            $diem_cuoi_ky = $_POST['txtDiemCuoiKy'];
            $class_id = $_POST['class_id']; 

            // Cập nhật điểm chi tiết trong cơ sở dữ liệu
            $kq = $this->diemtungmon->diemtungmon_upd($id, $lan_hoc, $lan_thi, $diem_chuyen_can, $diem_giua_ky, $diem_cuoi_ky);

            // Kiểm tra kết quả cập nhật
            if ($kq) {
                echo '<script>alert("Sửa điểm chi tiết thành công");</script>';
                $ma_giang_vien = $_SESSION['ma_tai_khoan']; // Lấy mã giảng viên từ session
                $this->view('Masterlayout_gv', [
                    'page' => 'DSdiem_gv',
                    'classes' => $this->diemtungmon->getClassesByLecturer($ma_giang_vien), // Lấy danh sách lớp
                    'dulieu' => $this->diemtungmon->getStudentScoresByClass($class_id) // Lấy danh sách điểm theo class_id
                ]);
                exit;
            } else {
                echo '<script>alert("Sửa điểm chi tiết thất bại");</script>';
            }
        }
    }

   
    
}

?>
