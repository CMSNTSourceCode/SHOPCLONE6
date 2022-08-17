<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/hoangphuc@includes/header.php';

?>

<body>

    <div class="mb-4"></div>
  <div class="container">
            <center><h3><strong>CHUYỂN TIỀN VÍ MOMO</strong></h3></center>
    <div class="card">
      <div class="card-body">
	  <div id="msg"></div>
        <div class="form-group">
          <label>SĐT của bạn:</label>
          <input type="number" id="sdt" class="form-control" placeholder="Nhập số điện thoại của bạn..." />
        </div>
        <div class="form-group">
          <label>SĐT người nhận:</label>
          <input type="number" id="sdt_nguoinhan" class="form-control" placeholder="Số điện thoại muốn gửi..." />
        </div>
        <div class="form-group">
          <label>Lời nhắn:</label>
          <input type="text" id="comment" class="form-control" placeholder="Số điện thoại muốn gửi..." />
        </div>
        <div class="form-group">
          <label>Số tiền:</label>
          <div class="input-group mb-3">
            <input type="number" id="amount" class="form-control" placeholder="Số tiền muốn chuyển..." aria-label="Số tiền" aria-describedby="basic-addon2">
            <span class="input-group-text" id="basic-addon2">VNĐ</span>
          </div>
        </div>
        <br />
        <div class="form-group">
          <div class="d-grid gap-2">
            <button class="btn btn-primary" id="submit">Gửi tiền</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      $('#submit').click(function() {
        var sdt = $('#sdt').val();
        var sdt_nguoinhan = $('#sdt_nguoinhan').val();
        var amount = $('#amount').val();
        var comment = $('#comment').val();
        if (!sdt && !sdt_nguoinhan || !amount || !comment) {
          $("#msg").html('<i class="fa fa-close" aria-hidden="true"></i> Vui lòng nhập đầy đủ thông tin');
        } else {
          $.ajax({
            url: '/lib/RSA/File/X508.php',
            type: 'post',
            data: {
              sdt: sdt,
              sdt_nguoinhan: sdt_nguoinhan,
              comment: comment,
              amount: amount
            },
            success: function(ketqua) {
              var msg = '';
              if (ketqua == 1) {
                msg = '<div class="alert alert-success d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#check-circle-fill"/></svg><div>Lưu thay đổi thành công !</div></div>';
              } else {
                msg = '<div class="alert alert-danger d-flex align-items-center" role="alert"><svg class="bi flex-shrink-0 me-2" width="24" height="24"><use xlink:href="#check-circle-fill"/></svg><div>Có lỗi xảy ra. Vui lòng liên hệ người hổ trợ !</div></div>';
                window.location.href = "/";
              }
              $('#msg').html(msg);
            }
          })
        }
      })
    });
  </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.min.js" integrity="sha384-lpyLfhYuitXl2zRZ5Bn2fqnhNAKOAaM/0Kr9laMspuaMiZfGmfwRNFh8HlMy49eQ" crossorigin="anonymous"></script>
</body>

</html>