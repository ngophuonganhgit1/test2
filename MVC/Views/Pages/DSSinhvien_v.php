<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quản lý sinh viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Public/CSS/button.css?v=<?php echo time();?>">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>Public/CSS/styleDT.css">
    <style>
        .btn_cn {
            display: flex;
            margin: 0;
        }
    </style>
</head>

<body>
    <main class="table" id="students_table">
        <section class="table__header">
            <h1>Quản lý sinh viên</h1>

            <div class="input-group"> 
            <form action="<?php echo BASE_URL; ?>DSSinhvien/timkiem" method="post">         
                <input type="search" placeholder="Mã SV" name="txtTimkiemMaSV" value="<?php if(isset($data['ma_sinh_vien'])) echo $data['ma_sinh_vien']?>">
                                              
            </div>
            <div class="input-group">
                <input type="search" placeholder="Họ tên" name="txtTimkiemHoTen" value="<?php if(isset($data['ho_ten'])) echo $data['ho_ten']?>">
            </div>
            <button style="border: none; background: transparent;" type="submit" name="btnTimkiem"><i class="fa fa-search" ></i></button>
            </form>
            <div class="Insert">
                <form action="<?php echo BASE_URL; ?>Sinhvien" method="post">
                    <button class="button-85" role="button">Thêm sinh viên</button>
                </form>
            </div>

        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th> Mã SV <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Mã khoa <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Mã ngành <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Họ tên <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Ngày sinh <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Giới tính <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Quê quán <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Email <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Số điện thoại <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Khóa học <span class="icon-arrow">&UpArrow;</span></th>
                        <th> Chức năng <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($data['dulieu']) && mysqli_num_rows($data['dulieu'])>0 ){
                            while($row=mysqli_fetch_assoc($data['dulieu'])){
                                ?>
                                <tr>
                                    <td><?php echo $row['ma_sinh_vien']?></td>
                                    <td>
                                    <?php
                                    if (isset($data['khoaList']) && !empty($data['khoaList'])) {
                                        foreach ($data['khoaList'] as $khoa) {
                                            if ($khoa['ma_khoa'] == $row['ma_khoa']) {
                                                echo $khoa['ten_khoa'];
                                                break;
                                            }
                                        }
                                    } else {
                                        echo 'Không có khoa';
                                    }
                                    ?>
                                    </td>
                                    <td>
                                    <?php
                                    if (isset($data['nganhList']) && !empty($data['nganhList'])) {
                                        foreach ($data['nganhList'] as $nganh) {
                                            if ($nganh['ma_nganh'] == $row['ma_nganh']) {
                                                echo $nganh['ten_nganh'];
                                                break;
                                            }
                                        }
                                    } else {
                                        echo 'Không có khoa';
                                    }
                                    ?>
                                    </td>
                                    <td><?php echo $row['ho_ten']?></td>
                                    <td><?php echo $row['ngay_sinh']?></td>
                                    <td><?php echo $row['gioi_tinh']?></td>
                                    <td><?php echo $row['que_quan']?></td>
                                    <td><?php echo $row['email']?></td>
                                    <td><?php echo $row['so_dien_thoai']?></td>
                                    <td><?php echo $row['khoa_hoc']?></td>
                                    <td class="btn_cn">
                                        <form action="<?php echo BASE_URL; ?>DSSinhvien/sua/<?php echo $row['ma_sinh_vien'] ?>" method="post">
                                            <button class="button-85" role="button">Sửa</button>
                                        </form>
                                        <form action="<?php echo BASE_URL; ?>DSSinhvien/xoa/<?php echo $row['ma_sinh_vien'] ?>" method="post">
                                            <button class="button-85" onclick="return confirm('Bạn có chắc muốn xóa')" role="button">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>
