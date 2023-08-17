<?php

require_once '../controllers/AuthController.php';
require_once '../controllers/PostController.php';
session_start();

if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}
if ($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])) {
    $postController = new PostController();
    $postController->deletePost($_GET['id']);

    $response = array('message' => 'Post deleted successfully.');
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
$postController = new PostController($conn);
$posts = $postController->getPosts("US0003");
// var_dump($posts);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- <script src="../css/script.js"></script> -->

</head>

<body>
    <h1>Home</h1>

    <button class="js-buy-ticket">Create</button>
    <div class="modal js-modal">
        <div class="modal-container js-modal-container">
            <form action="../actions/create_post.php" method="POST">

                <div class="modal-close js-modal-close">
                    <i class="ti-close fas fa-close"></i>
                </div>

                <header class="modal-header">
                    Create Post
                </header>

                <div class="modal-body">
                    <input type="hidden" name="submitted" value="1">

                    Title
                    <input type="text" class="modal-input" name="title" value="" placeholder="Enter Title...">

                    Level
                    <input type="text" class="modal-input" name="level" value="" placeholder="Enter Level...">

                    Experience
                    <input type="text" class="modal-input" name="experience" value="" placeholder="Enter Experience...">

                    Target
                    <input type="text" class="modal-input" name="target" value="" placeholder="Enter Target...">

                    Salary
                    <input type="text" class="modal-input" name="salary" value="" placeholder="Enter Salary...">

                    Address
                    <input type="text" class="modal-input" name="address" value="" placeholder="Enter Address...">

                    Phone
                    <input type="text" class="modal-input" name="phone" value="" placeholder="Enter Phone...">

                    <button id="buy-tickets" type="submit">
                        Create Post <i class="fas fa-check"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
    <script>
        const buyBtn = document.querySelector('.js-buy-ticket')
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



        buyBtn.addEventListener('click', showBuyTickets);


        // nghe hành vi click vào nút button close
        modalClose.addEventListener('click', hideBuyTickets);

        modal.addEventListener('click', hideBuyTickets);

        modalContainer.addEventListener('click', function(event) {
            event.stopPropagation();
        });
    </script>
    <div class="index">
        <div class="row">
            <p class="tittle">id</p>
            <p class="tittle">title</p>
            <p class="tittle">level</p>
            <p class="tittle">experience</p>
            <p class="tittle">target</p>
            <p class="tittle">salary</p>
            <p class="tittle">address</p>
            <p class="tittle">phone</p>
            <div>Update</div>

        </div>

        <?php foreach ($posts as $post) { ?>
            <div class="row">
                <p class="tittle"><?php echo $post['id']; ?></p>
                <p class="tittle"><?php echo $post['title']; ?></p>
                <p class="tittle"><?php echo $post['level']; ?></p>
                <p class="tittle"><?php echo $post['experience']; ?></p>
                <p class="tittle"><?php echo $post['target']; ?></p>
                <p class="tittle"><?php echo $post['salary']; ?></p>
                <p class="tittle"><?php echo $post['address']; ?></p>
                <p class="tittle"><?php echo $post['phone']; ?></p>
                <button class="js-buy-ticket2" data-postid="<?php echo $post['id']; ?>" id="<?php print $post['id']; ?>">Update</button>
                <button type="button" class="js-delete-post" data-post-id="<?= $post['id'] ?>">
                        <i class="ti-trash"></i> Delete
                </button>
            </div>

            <div class="nodal js-nodal" id="nodal-<?php echo $post['id']; ?>">
                <div class="nodal-container js-nodal-container">
                    <form action="../actions/update_post.php" method="POST">
                        <div class="nodal-close js-nodal-close">
                            <i class="ti-close fas fa-close" id="<?php print $post['id']; ?>"></i>
                        </div>

                        <header class="nodal-header">
                            Update Post
                        </header>

                        <div class="nodal-body">
                            <input type="hidden" name="submitted2" value="1">
                            <input type="hidden" name="postId" value="<?= htmlentities($post['id']) ?>">

                            ID
                            <input type="text" class="nodal-input" name="title" value="<?= htmlentities($post['id']) ?>" placeholder="Enter Id..." readonly>

                            Title
                            <input type="text" class="nodal-input" name="title" value="<?= htmlentities($post['title']) ?>" placeholder="Enter Title...">

                            Level
                            <input type="text" class="nodal-input" name="level" value="<?= htmlentities($post['level']) ?>" placeholder="Enter Level...">

                            Experience
                            <input type="text" class="nodal-input" name="experience" value="<?= htmlentities($post['experience']) ?>" placeholder="Enter Experience...">

                            Target
                            <input type="text" class="nodal-input" name="target" value="<?= htmlentities($post['target']) ?>" placeholder="Enter Target...">

                            Salary
                            <input type="text" class="nodal-input" name="salary" value="<?= htmlentities($post['salary']) ?>" placeholder="Enter Salary...">

                            Address
                            <input type="text" class="nodal-input" name="address" value="<?= htmlentities($post['address']) ?>" placeholder="Enter Address...">

                            Phone
                            <input type="text" class="nodal-input" name="phone" value="<?= htmlentities($post['phone']) ?>" placeholder="Enter Phone...">

                            <button id="buy-tickets" type="submit">
                                Update Post <i class="fas-check"></i>
                            </button>

                        </div>
                    </form>
                </div>
            </div>

        <?php } ?>


    </div>
    <a href="logout.php">Logout !</a>

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
                const postId = buyBtn2.getAttribute('data-postid');
                const nodalUpdate = document.querySelector(`.js-nodal#nodal-${postId}`);
                nodalUpdate.classList.add('open');
            });
        }
        // Lắng nghe sự kiện click cho nút đóng modal
        const nodalCloses = document.querySelectorAll('.js-nodal-close');
        for (const nodalClose of nodalCloses) {
            nodalClose.addEventListener('click', () => {
                nodalClose.closest('.js-nodal').classList.remove('open');
            });
        }
    </script>
     <script>
        const deleteBtns = document.querySelectorAll('.js-delete-post');

        function deletePost(postId) {
            if (confirm("Are you sure you want to delete this post?")) {
                fetch(`?id=${postId}`, {
                        method: 'DELETE'
                    }).then(response => response.json())
                    .then(data => {
                        console.log(data.message);
                        window.location.reload();
                    })
                    .catch(error => console.error(error));
            }
        }
        for (const deleteBtn of deleteBtns) {
            deleteBtn.addEventListener('click', () => {
                const postId = deleteBtn.getAttribute('data-post-id');
                deletePost(postId);
            });
        }
    </script>

</body>



</html>