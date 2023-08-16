<?php
    require_once '../controllers/PostController.php';

    $postC = new PostController();
    $postController = new PostController();
    $posts = $postController->index();
    // var_dump($posts);

    $_POST['submitted2'] = $_POST['submitted2'] ?? 0;
    $_POST['submitted'] = $_POST['submitted'] ?? 0;
    $_POST['id'] = $_POST['id'] ?? "";
    $_POST['title'] = $_POST['title'] ?? "";
    $_POST['level'] = $_POST['level'] ?? "";
    $_POST['experience'] = $_POST['experience'] ?? "";
    $_POST['target'] = $_POST['target'] ?? "";
    $_POST['salary'] = $_POST['salary'] ?? "";
    $_POST['address'] = $_POST['address'] ?? "";
    $_POST['phone'] = $_POST['phone'] ?? "";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style2.css">
    <link rel="stylesheet" href="../css/themify-icons/themify-icons.css">
</head>
<body>
    <h1>Danh sách bài viết</h1>

    <button class="js-buy-ticket"><i class="ti-plus"></i> Create</button>

    <div class="modal js-modal">
        <div class="modal-container js-modal-container">
            <form action="<?php $postController->create($_POST['submitted'], $_POST['title'], $_POST['level'], $_POST['experience'], $_POST['target'], $_POST['salary'], $_POST['address'], $_POST['phone']); ?>" method="post">
                <div class="modal-close js-modal-close">
                    <i class="ti-close"></i>
                </div>

                <header class="modal-header">
                    Create Post
                </header>

                <div class="modal-body">
                    <input type="hidden" name="submitted" value="1">

                    Title
                    <input type="text" class="modal-input" name="title" value="<?= @ htmlentities($_POST['title']) ?>" placeholder="Enter Title...">

                    Level
                    <input type="text" class="modal-input" name="level" value="<?= @ htmlentities($_POST['level']) ?>" placeholder="Enter Level...">

                    Experience
                    <input type="text" class="modal-input" name="experience" value="<?= @ htmlentities($_POST['experience']) ?>" placeholder="Enter Experience...">

                    Target
                    <input type="text" class="modal-input" name="target" value="<?= @ htmlentities($_POST['target']) ?>" placeholder="Enter Target...">

                    Salary
                    <input type="text" class="modal-input" name="salary" value="<?= @ htmlentities($_POST['salary']) ?>" placeholder="Enter Salary...">

                    Address
                    <input type="text" class="modal-input" name="address" value="<?= @ htmlentities($_POST['address']) ?>" placeholder="Enter Address...">

                    Phone
                    <input type="text" class="modal-input" name="phone" value="<?= @ htmlentities($_POST['phone']) ?>" placeholder="Enter Phone...">

                    <button id="buy-tickets" type="submit">
                        Create Post <i class="ti-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const buyBtns = document.querySelectorAll('.js-buy-ticket')
        const modal = document.querySelector('.js-modal')
        const modalContainer = document.querySelector('.js-modal-container')
        const modalClose = document.querySelector('.js-modal-close')

        // Hàm hiển thị modal mua vé (thêm class open vào modal)
        function showBuyTickets() {
            modal.classList.add('open')
        }

        // Hàm ẩn modal mua vé (gỡ bỏ class open vào modal)
        function hideBuyTickets() {
            modal.classList.remove('open')
        }

        // Lặp qua từng thẻ button và nghe hành vi click
        for (const buyBtn of buyBtns) {
            buyBtn.addEventListener('click', showBuyTickets);
        }

        // nghe hành vi click vào nút button close
        modalClose.addEventListener('click', hideBuyTickets);

        modal.addEventListener('click', hideBuyTickets);

        modalContainer.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    </script>

    <table>
        <tr>
            <th>title</th>
            <th>level</th>
            <th>experience</th>
            <th>target</th>
            <th>salary</th>
            <th>address</th>
            <th>phone</th>
            <th>update</th>
        </tr>
        <?php
            // for ($set = array (); $row = $posts->fetch_assoc(); $set[] = $row);
            // {
            //     print_r($set);
            // }
        ?>
        <?php

        foreach($posts as $post) { ?>
            <tr>
                <?php
                    $id = $post['id'];
                    $title = $post['title'];
                    $level = $post['level'];
                    $experience = $post['experience'];
                    $target = $post['target'];
                    $salary = $post['salary'];
                    $address = $post['address'];
                    $phone = $post['phone'];
                ?>
                <td><?php print $post['title']; ?></td>
                <td><?php print $post['level']; ?></td>
                <td><?php print $post['experience']; ?></td>
                <td><?php print $post['target']; ?></td>
                <td><?php print $post['salary']; ?></td>
                <td><?php print $post['address']; ?></td>   
                <td><?php print $post['phone']; ?></td>
                <td><button class="js-buy-ticket2" id="<?php print $post['id']; ?>" ><i class="ti-pencil"></i> Update <?php print $post['id']; ?></button></td>
                
                <div class="nodal js-nodal" id="<?php print $post['id']; ?>">
                    <div class="nodal-container js-nodal-container">
                        
                        <form action="<?php $postC->update($_POST['submitted2'], $_POST['id'], $_POST['title'], $_POST['level'], $_POST['experience'], $_POST['target'], $_POST['salary'], $_POST['address'], $_POST['phone']); echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="nodal-close js-nodal-close">
                                <i class="ti-close" id="<?php print $post['id']; ?>" ></i>
                            </div>

                            <header class="nodal-header">
                                Update Post
                            </header>

                            <div class="nodal-body">
                                <input type="hidden" name="submitted2" value="1">
                                <?php $_POST['id'] = $id ?>

                                Title
                                <input type="text" class="nodal-input" name="title" value="<?= @ htmlentities($title) ?>" placeholder="Enter Title...">

                                Level
                                <input type="text" class="nodal-input" name="level" value="<?= @ htmlentities($level) ?>" placeholder="Enter Level...">

                                Experience
                                <input type="text" class="nodal-input" name="experience" value="<?= @ htmlentities($experience) ?>" placeholder="Enter Experience...">

                                Target
                                <input type="text" class="nodal-input" name="target" value="<?= @ htmlentities($target) ?>" placeholder="Enter Target...">

                                Salary
                                <input type="text" class="nodal-input" name="salary" value="<?= @ htmlentities($salary) ?>" placeholder="Enter Salary...">

                                Address
                                <input type="text" class="nodal-input" name="address" value="<?= @ htmlentities($address) ?>" placeholder="Enter Address...">

                                Phone
                                <input type="text" class="nodal-input" name="phone" value="<?= @ htmlentities($phone) ?>" placeholder="Enter Phone...">

                                <button id="buy-tickets" type="submit">
                                    Update Post <i class="ti-check"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </tr>
        <?php } ?>

    </table>

    <script>
        const buyBtns2 = document.querySelectorAll('.js-buy-ticket2')
        const nodal = document.querySelector('.js-nodal')
        console.log(nodal)
        const nodalContainer = document.querySelector('.js-nodal-container')
        const nodalClose = document.querySelector('.js-nodal-close')
        const ti_close = document.querySelector('.ti-close')

        // Hàm hiển thị nodal mua vé (thêm class open vào nodal)
        function showBuyTickets(PostId) {
            const nodalUpdate = document.querySelectorAll('.js-nodal#' + PostId);
            // console.log(nodalUpdate);
            nodalUpdate[0].classList.add('open');
            // Hàm ẩn nodal mua vé (gỡ bỏ class open vào nodal)
            const nodalDelete = document.querySelector('.ti-close#' + PostId);
            nodalDelete.addEventListener('click', () => {
                nodalUpdate[0].classList.remove("open");
            });
        }

        // Lặp qua từng thẻ button và nghe hành vi click
        for (const buyBtn2 of buyBtns2) {
            buyBtn2.addEventListener('click', () => {
                const PostId = buyBtn2.getAttribute('id');
                console.log(PostId);
                showBuyTickets(PostId);
            });
        }
    </script>
</body>
</html>
