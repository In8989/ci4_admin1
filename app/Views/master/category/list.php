<!-- Content -->
<div class="layout-page">
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Board Config /</span> List</h4>

            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Board List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>카테고리명</th>
                            <th>상태</th>
                            <th>1차분류</th>
                            <th>2차분류</th>
                            <th>순서</th>
                            <th>수정/삭제</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <tr>
                                <td>
                                    <?php echo $list[$i]['cat_title'] ?>
                                    <?php if ($list[$i]['cat_level'] === '1') { ?>
                                        <a href="<?php echo $currentURL ?>/edit?idx=<?php echo $list[$i][$primaryKey] ?>&mode=addChild"><button type="button">하위추가</button></a>
                                    <?php } ?>
                                </td>
                                <td><?php echo $list[$i]['cat_state'] === '1' ? '사용' : '사용안함'; ?></td>
                                <td><?php echo $list[$i]['cat_group'] ?></td>
                                <td><?php echo $list[$i]['cat_level'] ?></td>
                                <td><?php echo $list[$i]['cat_sort'] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?php echo $currentURL ?>/edit?idx=<?php echo $list[$i][$primaryKey] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="<?php echo $currentURL ?>/delete?idx=<?php echo $list[$i][$primaryKey] ?>"><i class="bx bx-trash me-1"></i> Delete</a>
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
            <a href="<?php echo $currentURL ?>/edit"><button type="button">추가</button></a>
            <!--/ Basic Bootstrap Table -->

        </div>
        <!-- / Content -->

        <!-- Footer -->

        <!-- / Footer -->

        <div class="content-backdrop fade"></div>
    </div>
</div>
<!-- / Content -->
