<!-- Content -->
<div class="layout-page">
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light"><?php echo $conf['boc_title'] ?> /</span> List</h4>

            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header"><?php echo $boc_code ?> List</h5>

                <div class="table-responsive text-nowrap">
                    <div class="row mb-5">
                        <?php
                        for ($i = 0; $i < count($list); $i++) {
                            $row = $list[$i];
                            if (isset($bof_list[$row['bod_idx']])) {
                                foreach ($bof_list[$row['bod_idx']] as $bof) { ?>
                                    <div class="col-md-6 col-lg-4 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $row['bod_title'] ?></h5>
                                                <h6 class="card-subtitle text-muted"><?php echo $row['bod_writer_name'] ?></h6>
                                                <img class="img-fluid d-flex mx-auto my-4" src="/uploaded/file/<?php echo $bof['bof_file_save'] ?>" alt="Card image cap">
                                                <p class="card-text"><?php echo $row['bod_content'] ?></p>
                                                <a class="card-link" href="<?php echo $write_page ?>?idx=<?php echo $list[$i][$primaryKey] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                                <a class="card-link" href="<?php echo $write_page ?>?idx=<?php echo $list[$i][$primaryKey] ?>"><i class="bx bx-trash me-1"></i> Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php break;
                                }
                            }
                        } ?>
                    </div>
                </div>
            </div>

            <div class="pageNavion">
                <?= $links ?>
            </div>
            <a href="<?php echo $write_page ?>">
                <button type="button">추가</button>
            </a>
            <!--/ Basic Bootstrap Table -->

        </div>
        <!-- / Content -->

        <!-- Footer -->

        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
</div>
<!-- / Content -->
