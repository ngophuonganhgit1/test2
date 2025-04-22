<?php
 class DSTaikhoan extends controller{
    private $dstk;
    function __construct()
    {
        $this->dstk=$this->model('Taikhoan_m');
    }
    // getdata de hien thi du lieu khi load trang
    function Get_data(){
        $this->view('Masterlayout_admin',[
            'page'=>'DSTaikhoan_v',
            'dulieu'=>$this->dstk->taikhoan_find('','')
        ]);
    }
    function Timkiem(){
        if(isset($_POST['btnTimkiem'])){
           
            $id=$_POST['txtTKID'];
            $quyen=$_POST['txtTKQuyen']; // lay du lieu nhap tu txt  
            
            $dl=$this->dstk->taikhoan_find($id,$quyen); // goi ham tim kiem
            // goi lai giao dien render lại trang va truyen $ dl ra 
            $this->view('Masterlayout_admin',[
                'page'=>'DSTaikhoan_v',
                'dulieu'=>$dl,
                'ma_tai_khoan'=>$id,
                'phan_quyen'=>$quyen
            ]);
        
    }

    }

   

    function xoa($id){
        $kq=$this->dstk->taikhoan_del($id);
        if($kq){
            echo '<script>
            alert("Xóa thành công");
           window.location.href = "' . BASE_URL . 'DSTaikhoan";
                </script>';
    exit();
        }
        else{
            echo'<script>alert("Xóa thất bại")</script>';
        }
       
    

    }
    function sua($id){
        $this->view('Masterlayout_admin',[
            'page'=>'Taikhoan_sua',
            'dulieu'=>$this->dstk->taikhoan_find($id,"")
        ]);
    }
    function suadl(){
        if(isset($_POST['btnLuu'])){
            $id=$_POST['txtId'];
            $tendn=$_POST['txtTendn'];
            $mk=$_POST['txtMatkhau'];
            $email=$_POST['txtEmail'];
            $quyen=$_POST['txtQuyen'];
           
            
                    // gọi hàm chèn dl tacgia_ins trong model tacgia_m
            $kq=$this->dstk->taikhoan_upd($id, $tendn, $mk, $email, $quyen);
            if($kq){
                echo'<script>alert("Sửa thành công")</script>';
            }
            else{
                echo'<script>alert("Sửa thất bại")</script>';
            }
            
            // gọi lại giao diện
            $this->view('Masterlayout_admin',[
                'page'=>'DSTaikhoan_v',
                'dulieu'=>$this->dstk->taikhoan_find('','')
            ]);
           
        }
    }
}
?>