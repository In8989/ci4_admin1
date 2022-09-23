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
                            <th>게시판명</th>
                            <th>게시판코드</th>
                            <th>접근권한</th>
                            <th>읽기권한</th>
                            <th>쓰기권한</th>
                            <th>답변권한</th>
                            <th>수정/삭제</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        <?php for ($i = 0; $i < count($list); $i++) { ?>
                            <tr>
                                <td><?php echo $list[$i]['boc_title'] ?></td>
                                <td><?php echo $list[$i]['boc_code'] ?></td>
                                <td><?php echo $list[$i]['boc_auth_list'] ?></td>
                                <td><?php echo $list[$i]['boc_auth_read'] ?></td>
                                <td><?php echo $list[$i]['boc_auth_write'] ?></td>
                                <td><?php echo $list[$i]['boc_auth_reply'] ?></td>
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
