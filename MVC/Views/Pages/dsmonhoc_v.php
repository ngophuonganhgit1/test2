<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>Public/CSS/button.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>Public/CSS/styleDT.css">
    <style>
        .btn_cn {
            display: flex;
            margin: 0;
        }
    </style>
</head>
<body>
    <form method="post" action="<?php echo BASE_URL; ?>dsmonhoc/timkiem"></form>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>Quản lý môn học</h1>
            <div class="input-group">
                <form action="<?php echo BASE_URL; ?>dsmonhoc/timkiem" method="post">        
                    <input type="search" placeholder="Tên môn" name="txtTKTenMon" value="<?php if(isset($data['ten_mon'])) echo $data['ten_mon'] ?>">
            </div>
            <div class="input-group">
                <form action="<?php echo BASE_URL; ?>dsmonhoc/timkiem" method="post">        
                    <input type="search" placeholder="Mã môn" name="txtTKMaMon" value="<?php if(isset($data['ma_mon'])) echo $data['ma_mon'] ?>">
            </div>
            <button style="border: none; background: transparent;" type="submit" name="btnTimkiem"><i class="fa fa-search" ></i></button>
            </form>  
            
            <div class="Insert">
                <form action="<?php echo BASE_URL; ?>monhoc" method="post">
                <button class="button-85" role="button">Thêm môn học</button>
                </form>
            </div>

           

           
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>Mã môn <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Tên môn <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Mã ngành <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Số tín chỉ <span class="icon-arrow">&UpArrow;</span></th>
                        <th>Số tiết <span class="icon-arrow">&UpArrow;</span></th>
                        <th style="padding-left:50px">Chức năng <span class="icon-arrow">&UpArrow;</span></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if(isset($data['dulieu']) && mysqli_num_rows($data['dulieu'])>0) {
                            while($row = mysqli_fetch_assoc($data['dulieu'])) {
                                ?>
                                <tr>
                                    <td><?php echo $row['ma_mon'] ?></td>
                                    <td><?php echo $row['ten_mon'] ?></td>
                                    <td><?php echo $row['ma_nganh'] ?></td>
                                    <td><?php echo $row['so_tin_chi'] ?></td>
                                    <td><?php echo $row['so_tiet'] ?></td>
                                    <td class="btn_cn">
                                        <form action="<?php echo BASE_URL; ?>dsmonhoc/sua/<?php echo $row['ma_mon'] ?>" method="post">
                                            <button class="button-85" role="button">Sửa</button>
                                        </form>

                                        <form action="<?php echo BASE_URL; ?>dsmonhoc/xoa/<?php echo $row['ma_mon'] ?>" method="post">
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