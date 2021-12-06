
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        body {
            margin-top: 20px;
            color: #484b51;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
        }

        .bill .text-secondary-d1 {
            color: #728299;
        }

        .bill .page-header {
            margin: 0 0 1rem;
            padding-bottom: 1rem;
            padding-top: 0.5rem;
            border-bottom: 1px dotted #e2e2e2;
            display: -ms-flexbox;
            display: flex;
            -ms-flex-pack: justify;
            justify-content: space-between;
            -ms-flex-align: center;
            align-items: center;
        }

        .bill .page-title {
            padding: 0;
            margin: 0;
            font-size: 1.75rem;
            font-weight: 300;
        }

        .bill .brc-default-l1 {
            border-color: #dce9f0;
        }

        .bill .ml-n1,
        .bill .mx-n1 {
            margin-left: -0.25rem;
        }

        .bill .mr-n1,
        .bill .mx-n1 {
            margin-right: -0.25rem;
        }

        .bill .mb-4,
        .bill .my-4 {
            margin-bottom: 1.5rem;
        }

        .bill hr {
            margin-top: 1rem;
            margin-bottom: 1rem;
            border: 0;
            border-top: 1px solid rgba(0, 0, 0, 0.1);
        }

        .bill .text-grey-m2 {
            color: #888a8d;
        }

        .bill .text-success-m2 {
            color: #86bd68;
        }

        .bill .font-bolder,
        .bill .text-600 {
            font-weight: 600;
        }

        .bill .text-110 {
            font-size: 110%;
        }

        .bill .text-blue {
            color: #248b4b;
        }

        .bill .pb-25,
        .bill .py-25 {
            padding-bottom: 0.75rem;
        }

        .bill .pt-25,
        .bill .py-25 {
            padding-top: 0.75rem;
        }

        .bill .bgc-default-tp1 {
            background-color: #248b4b;
        }

        .bill .bgc-default-l4,
        .bill .bgc-h-default-l4:hover {
            background-color: #f3f8fa;
        }

        .bill .page-header .page-tools {
            -ms-flex-item-align: end;
            align-self: flex-end;
        }

        .bill .btn-light {
            color: #757984;
            background-color: #f5f6f9;
            border-color: #dddfe4;
        }

        .bill .w-2 {
            width: 1rem;
        }

        .bill .text-120 {
            font-size: 120%;
        }

        .bill .text-primary-m1 {
            color: #4087d4;
        }

        .bill .text-danger-m1 {
            color: #dd4949;
        }

        .bill .text-blue-m2 {
            color: #68a3d5;
        }

        .bill .text-150 {
            font-size: 150%;
        }

        .bill .text-60 {
            font-size: 60%;
        }

        .bill .text-grey-m1 {
            color: #7b7d81;
        }

        .bill .align-bottom {
            vertical-align: bottom;
        }

        .bill .bt_1 {
            border-bottom: 1px solid #248b4b;
            border-left: 1px solid #248b4b;
            border-right: 1px solid #248b4b;
        }

        .bill .bt-2 {
            border-bottom: 1px solid #248b4b;

        }

        .bill .bt-3 {
            border-left: 1px solid #248b4b;
            border-right: 1px solid #248b4b;
        }

        .bill hr {
            color: #248b4b;
        }

        .text-cts {
            color: #298c4f;

        }

        .bd-m {
            border: 1px solid #248b4b;
        }

        .header_mail {
            background: #248b4b;
        }

        .header_mail span {
            padding: 20px;
            display: block;
        }

        .header__mail .tt_mail {
            padding: 20px;
            display: block;
        }
    </style>
</head>
<body>
    <section class="section-all bill">
        <div class="container">
            <div class="col-lg-6 m-auto bd-m p-0">
                <div class="header_mail">
                    <span class="text-150 text-white">Đơn hàng mới của bạn tại MarkVeget</span>
                </div>
                <div class="header__mail">
                    <div class="tt_mail">
                        <span class="d-block">Bạn vừa nhận được đơn hàng mới từ ...</span>
                        <span class="d-block">Đơn hàng: ...</span>
                    </div>
                </div>
                <div class="col-lg-11 m-auto">
                    <div class="mt-1">
                        <div class="row text-600 text-white bgc-default-tp1 py-3">
                            <div class="col-lg-5 col-md-5 col-5 text-center">Sản phẩm</div>
                            <div class="col-lg-3 col-md-3 col-3 text-center">Số lượng</div>
                            <div class="col-lg-4 col-md-4 col-4 text-center">Giá</div>
                        </div>

                        <div class="text-95 text-secondary-d3">
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-5 col-md-5 col-5 text-center">Táo</div>
                                <div class="col-lg-3 col-md-3 col-3 text-center">2</div>
                                <div class="col-lg-4 col-md-4 col-4 text-center text-secondary-d2 ">200.000 đ</div>
                            </div>

                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-5 col-md-5 col-5 text-center">Vải</div>
                                <div class="col-lg-3 col-md-3 col-3 text-center">3</div>
                                <div class="col-lg-4 col-md-4 col-4 text-center text-secondary-d2">270.000 đ</div>
                            </div>
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-5 col-md-5 col-5 text-center">Cóc</div>
                                <div class="col-lg-3 col-md-3 col-3 text-center">10</div>
                                <div class="col-lg-4 col-md-4 col-4 text-center text-secondary-d2">500.000 đ</div>
                            </div>
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-5 col-md-5 col-5 text-center">Ổi</div>
                                <div class="col-lg-3 col-md-3 col-3 text-center">3</div>
                                <div class="col-lg-4 col-md-4 col-4 text-center text-secondary-d2">210.000 đ</div>
                            </div>
                        </div>
                        <div class="text-95 text-secondary-d3">
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-8 col-md-8 col-8 ">
                                    Tổng:
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <span class="text-120 text-center d-block">1.180.000 đ</span>
                                </div>
                            </div>
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-8 col-md-8 col-8 ">
                                    Thuế (10%)
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <span class="text-110 text-center d-block">180.000 đ</span>
                                </div>
                            </div>
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-8 col-md-8 col-8 ">
                                    Mã giảm giá:
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <span class="text-110 text-center d-block">Không có</span>
                                </div>
                            </div>
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-8 col-md-8 col-8 ">
                                    Phương thức thanh toán:
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <span class="text-110 text-center d-block">Thanh toán khi nhận hàng</span>
                                </div>
                            </div>
                            <div class="row mb-sm-0 py-3 bt_1">
                                <div class="col-lg-8 col-md-8 col-8 ">
                                    Tổng cộng:
                                </div>
                                <div class="col-lg-4 col-md-4 col-4">
                                    <span class="text-150 text-center d-block">1.360.000 đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-block mt-3">
                        <p class="text-150">Thông tin khách hàng</p>
                        <div class="row pt-3">
                            <div class="col-lg-6 ">
                                <p>Khách hàng:... </p>
                                <p>Địa chỉ:... </p>
                                <p>Số diện thoại:... </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
</html>