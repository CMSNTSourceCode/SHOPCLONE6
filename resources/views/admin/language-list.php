<?php if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$body = [
    'title' => 'Danh sách ngôn ngữ',
    'desc'   => 'CMSNT Panel',
    'keyword' => 'cmsnt, CMSNT, cmsnt.co,'
];
$body['header'] = '

';
$body['footer'] = '

';
require_once(__DIR__.'/../../../models/is_admin.php');
require_once(__DIR__.'/header.php');
require_once(__DIR__.'/sidebar.php');
require_once(__DIR__.'/nav.php');
?>

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Danh sách ngôn ngữ</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?=BASE_URL('admin/');?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Danh sách ngôn ngữ</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <section class="col-lg-6">
                </section>
                <section class="col-lg-6">
                    <div class="text-right mb-3">
                        <a class="btn btn-primary" type="button" href="<?=BASE_URL('admin/language-add');?>"><i
                                class="fas fa-plus-circle mr-1"></i>Add Language</a>
                    </div>
                </section>
                <section class="col-lg-12 connectedSortable">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-globe-asia mr-1"></i>
                                DANH SÁCH NGÔN NGỮ
                            </h3>
                            <div class="card-tools">
                                <button type="button" class="btn bg-success btn-sm" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn bg-warning btn-sm" data-card-widget="maximize"><i
                                        class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn bg-danger btn-sm" data-card-widget="remove">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5px;">#</th>
                                        <th>Languages</th>
                                        <th>Icon</th>
                                        <th>Default</th>
                                        <th>Status</th>
                                        <th style="width: 20%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($CMSNT->get_list("SELECT * FROM `languages` ORDER BY `id` DESC ") as $row) {?>
                                    <tr>
                                        <td><?=$row['id'];?></td>
                                        <td><?=$row['lang'];?></td>
                                        <td><img width="50px" src="<?=base_url($row['icon']);?>"></td>
                                        <td><?=display_mark($row['lang_default']);?></td>
                                        <td><?=display_status_product($row['status']);?></td>
                                        <td>
                                            <button style="color:white;" onclick="setDefault('<?=$row['id'];?>')"
                                                class="btn btn-dark btn-sm btn-icon-left m-b-10 setDefault"
                                                type="button">
                                                <i class="fas fa-key mr-1"></i><span class="">Set Default</span>
                                            </button>
                                            <a aria-label="" href="<?=base_url('admin/translate-list/'.$row['id']);?>"
                                                style="color:white;" class="btn btn-primary btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-language mr-1"></i><span class="">Translate</span>
                                            </a>
                                            <a aria-label="" href="<?=base_url('admin/language-edit/'.$row['id']);?>"
                                                style="color:white;" class="btn btn-info btn-sm btn-icon-left m-b-10"
                                                type="button">
                                                <i class="fas fa-edit mr-1"></i><span class="">Edit</span>
                                            </a>
                                            <button style="color:white;" onclick="RemoveRow('<?=$row['id'];?>')"
                                                class="btn btn-danger btn-sm btn-icon-left m-b-10" type="button">
                                                <i class="fas fa-trash mr-1"></i><span class="">Delete</span>
                                            </button>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <p>Xem hướng dẫn sử dụng tại đây: <a target="_blank" href="https://www.youtube.com/watch?v=zyn541CIJBQ&list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW&index=2">https://www.youtube.com/watch?v=zyn541CIJBQ&list=PLylqe6Lzq699BYT-ZXL5ZZg4gaNqwGpEW&index=2</a></p>
                </section>
            </div>
        </div>
    </div>
</div>
<?php
require_once(__DIR__.'/footer.php');
?>
<script type="text/javascript">
function setDefault(id) {
    $('.setDefault').html('<i class="fa fa-spinner fa-spin"></i> Loading...').prop('disabled',
        true);
    $.ajax({
        url: "<?=BASE_URL("ajaxs/admin/setDefaultLanguage.php");?>",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id
        },
        success: function(respone) {
            if (respone.status == 'success') {
                cuteToast({
                    type: "success",
                    message: respone.msg,
                    timer: 5000
                });
                location.reload();
            } else {
                cuteAlert({
                    type: "error",
                    title: "Error",
                    message: respone.msg,
                    buttonText: "Okay"
                });
            }
        },
        error: function() {
            alert(html(response));
            location.reload();
        }
    });
}

function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Ngôn Ngữ",
        message: "Bạn có chắc chắn muốn xóa ngôn ngữ ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL("ajaxs/admin/removeLanguage.php");?>",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>