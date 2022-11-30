<!-- Content -->
<div class="layout-page">
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <span class="app-brand-text demo text-body fw-bolder">MAIN</span>
                        </div>

                        <?php

                        foreach ($boc as $board) {
                            echo "<a href='/board/".$board['boc_code']."'>".$board['boc_title']."</a><br/>";
                        }
                        ?>

                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
</div>
<!-- / Content -->
