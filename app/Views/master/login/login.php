<!DOCTYPE html>
<html>
<?php echo $head?>
<!-- BEGIN BODY -->

<body class="no-top " >

<div class="container">
    <div class="row login-container ">
        <div class="col-md-7 col-md-offset-2 tiles white no-padding">
            <div class="p-t-30 p-l-40 p-b-20 xs-p-t-10 xs-p-l-10 xs-p-b-10">
                <h2 class="normal">관리자 로그인</h2>
                <p>해당 기능은  관리자만 접속이 가능합니다.</p>
            </div>
            <div class="tiles grey p-t-20 p-b-20 no-margin text-black tab-content">
                <div role="tabpanel" class="tab-pane active" id="tab_login">


                    <form method="post">
                        <div class="row form-row m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                            <div class="col-md-6 col-sm-6">
                                아이디<br>
                                <input class="form-control mt10" id="mem_id" name="mem_id" placeholder="아이디 입력" type="text" required="" aria-required="true" value="">
                            </div>
                            <div class="col-md-6 col-sm-6">
                                비밀번호<br>
                                <input class="form-control mt10" id="mem_pass" name="mem_pass" placeholder="비밀번호 입력" type="password" required="" aria-required="true">
                            </div>
                        </div>
                        <div class="row p-t-10 m-l-20 m-r-20 xs-m-l-10 xs-m-r-10">
                            <div class="control-group col-md-12">

                                <div class="checkbox checkbox check-success hidden">
                                    <!-- <a href="#">Trouble login in?</a>&nbsp;&nbsp; -->
                                    <input id="checkbox1" type="checkbox" value="1" name='id_save' value='1'>
                                    <label for="checkbox1">아이디 기억하기</label>
                                </div>
                                <button type="submit" class='btn btn-primary w100per'>로그인</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(function () {
        $("#inMpass").focus();
        $("#inMID").focus();
    });
</script>


</body>
</html>
