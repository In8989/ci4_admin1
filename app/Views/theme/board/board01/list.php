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
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>NAME</th>
                            <th>TITLE</th>
                            <th>CONTENT</th>
                            <th>REGISTE</th>
                            <th>ACTIVE</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <tr>
                                <td><?php echo $list[$i]['bod_mem_id'] ?></td>
                                <td><?php echo $list[$i]['bod_writer_name'] ?></td>
                                <td><?php echo $list[$i]['bod_title'] ?></td>
                                <td><?php echo $list[$i]['bod_content'] ?></td>
                                <td><?php echo $list[$i]['bod_created_at'] ?></td>

                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?php echo $write_page ?>?idx=<?php echo $list[$i][$primaryKey] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="<?php echo $download_page ?>?idx=<?php echo $list[$i][$primaryKey] ?>"><i class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="pageNavion">
                <?= $links ?>
            </div>
            <a href="<?php echo $write_page ?>"><button type="button">추가</button></a>
            <!--/ Basic Bootstrap Table -->

        </div>
        <!-- / Content -->

        <!-- Footer -->

        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
</div>
<!-- / Content -->
