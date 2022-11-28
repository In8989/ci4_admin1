<!-- Content -->
<div class="layout-page">
    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Board Config /</span> List</h4>

            <!-- Search Form -->
            <form method="get">
                <div class="card">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="NAME SEARCH" name="search_obj1">
                    </div>
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="TEL SEARCH" name="search_obj2">
                    </div>
                </div>
                <div><button>검색</button></div>
            </form>
            <!--/ Search Form -->

            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Board List</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>제목</th>
                            <th>부제목</th>
                            <th>상태</th>
                            <th>일반가격</th>
                            <th>할인가격</th>
                            <th>수정/삭제</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php foreach ($list as $key => $item) { ?>
                            <tr>
                                <td><?php echo $item['prd_title'] ?></td>
                                <td><?php echo $item['prd_subtitle'] ?></td>
                                <td><?php echo $item['prd_state'] === '1' ? '사용' : '사용안함'; ?></td>
                                <td><?php echo $item['prd_common_price'] ?></td>
                                <td><?php echo $item['prd_price'] ?></td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="bx bx-dots-vertical-rounded"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="<?php echo $currentURL ?>/edit?idx=<?php echo $item[$primaryKey] ?>"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item" href="<?php echo $currentURL ?>/delete?idx=<?php echo $item[$primaryKey] ?>"><i class="bx bx-trash me-1"></i> Delete</a>
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
