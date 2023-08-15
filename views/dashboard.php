<?php
    session_start();
    require_once '../controllers/PostController.php';

    $postController = new PostController();
    $posts = $postController->index();
    // var_dump($posts);

    $_POST['submitted2'] = $_POST['submitted2'] ?? 0;
    $_POST['submitted'] = $_POST['submitted'] ?? 0;
    $_POST['title'] = $_POST['title'] ?? 0;
    $_POST['level'] = $_POST['level'] ?? 0;
    $_POST['experience'] = $_POST['experience'] ?? 0;
    $_POST['target'] = $_POST['target'] ?? 0;
    $_POST['salary'] = $_POST['salary'] ?? 0;
    $_POST['address'] = $_POST['address'] ?? 0;
    $_POST['phone'] = $_POST['phone'] ?? 0;
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
            <form action="<?php $postController->create($_POST['submitted'], $_POST['title'], $_POST['level'], $_POST['experience'], $_POST['target'], $_POST['salary'], $_POST['address'], $_POST['phone']) ?>" method="post">
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
                    $_POST['title'] = $post['title'];
                    $_POST['level'] = $post['level'];
                    $_POST['experience'] = $post['experience'];
                    $_POST['target'] = $post['target'];
                    $_POST['salary'] = $post['salary'];
                    $_POST['address'] = $post['address'];
                    $_POST['phone'] = $post['phone'];
                    // var_dump($post);
                    // dd($posts);
                    // var_dump(strlen($post['title']));
                    // var_dump(count($post));
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
                        
                        <form action="" method="post">
                            <div class="nodal-close js-nodal-close">
                                <i class="ti-close"></i>
                            </div>

                            <header class="nodal-header">
                                Update Post
                            </header>

                            <div class="nodal-body">
                                <input type="hidden" name="submitted2" value="1">

                                Title
                                <input type="text" class="nodal-input" name="title" value="<?= @ htmlentities($_POST['title']) ?>" placeholder="Enter Title...">

                                Level
                                <input type="text" class="nodal-input" name="level" value="<?= @ htmlentities($_POST['level']) ?>" placeholder="Enter Level...">

                                Experience
                                <input type="text" class="nodal-input" name="experience" value="<?= @ htmlentities($_POST['experience']) ?>" placeholder="Enter Experience...">

                                Target
                                <input type="text" class="nodal-input" name="target" value="<?= @ htmlentities($_POST['target']) ?>" placeholder="Enter Target...">

                                Salary
                                <input type="text" class="nodal-input" name="salary" value="<?= @ htmlentities($_POST['salary']) ?>" placeholder="Enter Salary...">

                                Address
                                <input type="text" class="nodal-input" name="address" value="<?= @ htmlentities($_POST['address']) ?>" placeholder="Enter Address...">

                                Phone
                                <input type="text" class="nodal-input" name="phone" value="<?= @ htmlentities($_POST['phone']) ?>" placeholder="Enter Phone...">

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
        const nodalContainer = document.querySelector('.js-nodal-container')
        const nodalClose = document.querySelector('.js-nodal-close')

        // Hàm hiển thị nodal mua vé (thêm class open vào nodal)
        function showBuyTickets(PostId) {
            const nodal = document.querySelectorAll('.js-nodal#' + PostId);
            console.log(nodal);
            nodal[0].classList.add('open');
        }

        // Hàm ẩn nodal mua vé (gỡ bỏ class open vào nodal)
        function hideBuyTickets() {
            const nodal = document.querySelectorAll('.ti-close');
            console.log(nodal);
            nodal[0].classList.remove('open');
        }

        // Lặp qua từng thẻ button và nghe hành vi click
        for (const buyBtn2 of buyBtns2) {
            buyBtn2.addEventListener('click', () => {
                const PostId = buyBtn2.getAttribute('id');
                console.log(PostId);
                showBuyTickets(PostId);
            });
        }

        // nghe hành vi click vào nút button close
        nodalClose.addEventListener('click', hideBuyTickets());

        // nodal.addEventListener('click', hideBuyTickets);

        nodalContainer.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    </script>
</body>
</html>
