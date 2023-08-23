<script type="module">
    import { createFormScript, updateFormScript, deleteFormScript } from '../public/js/modal.js';

    createFormScript();
    updateFormScript();
    deleteFormScript();
</script>
<?php

require_once '../controllers/AuthController.php';
require_once '../controllers/PostController.php';
session_start();

if (!isset($_SESSION['user_success'])) {
    header('location:login.php');
}
$postController = new PostController($conn);
$posts = $postController->getPosts($_SESSION['user_success']);
// var_dump($posts);
// echo $_SESSION['user_success'];

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- <script src="../css/script.js"></script> -->

</head>

<body>
    <div class="container-header">
        <div class="header">
            <p class="page-tittle">Vlearn</p>
            <div class="info">
                <div class="username">
                    Hello, <?php echo $_SESSION['username'] ?> !
                </div>
                <a href="logout.php"><button class='btn-logout'>Log Out |-></button></a>
            </div>
        </div>

    </div>
    <button class="js-buy-ticket create-btn">Create +</button>
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
                    <input required type="text" class="modal-input" name="title" value="<?= @ htmlentities($post['title']) ?>" placeholder="Enter Title...">

                    Level
                    <select required class="nodal-input" name="level">
                        <option value="Sơ Cấp">Sơ Cấp</option>
                        <option value="Trung Cấp">Trung Cấp</option>
                        <option value="Cao Cấp">Cao Cấp</option>
                    </select>

                    <div class="input-container">
                        <label for="experience">Experience</label>
                        <input required type="text" class="modal-input" name="experience" value="<?= @ htmlentities($post['experience']) ?>" placeholder="Enter Experience...">
                        <div class="error-msg"></div>
                    </div>

                    Target
                    <select required class="nodal-input" name="target">
                        <option value="Giao Tiếp">Giao Tiếp</option>
                        <option value="Luyện Thi">Luyện Thi</option>
                        <option value="Business">Business</option>
                    </select>

                    <div class="input-container">
                        <label for="salary">Salary</label>
                        <input required type="text" class="modal-input" name="salary" value="<?= @ htmlentities($post['salary']) ?>" placeholder="Enter Salary...">
                        <div class="error-msg"></div>
                    </div>
                    Address
                    <input required type="text" class="modal-input" name="address" value="<?= @ htmlentities($post['address']) ?>" placeholder="Enter Address...">

                    <div class="input-container">
                        <label for="phone">Phone</label>
                        <input required type="text" class="modal-input" name="phone" value="<?= @ htmlentities($post['phone']) ?>" placeholder="Enter Phone...">
                        <div class="error-msg"></div>
                    </div>
                    <button id="buy-tickets" type="submit">
                        Create Post <i class="fas fa-check"></i>
                    </button>
                </div>

            </form>
        </div>
    </div>
    <div class="index">
        <table id="books">
            <tr>
                <th>id</th>
                <th>title</th>
                <th>level</th>
                <th>experience</th>
                <th>target</th>
                <th>salary</th>
                <th>address</th>
                <th>phone</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($posts as $post) { ?>
                <tr>
                    <td class="tittle"><?php echo htmlentities($post['id']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['title']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['level']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['experience']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['target']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['salary']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['address']); ?></td>
                    <td class="tittle"><?php echo htmlentities($post['phone']); ?></td>
                    <td><button class="js-buy-ticket2 update-btn" data-postid="<?php echo $post['id']; ?>" id="<?php print $post['id']; ?>">Update</button> </td>
                    <td> <button type="button" class="js-delete-post delete-btn" data-post-id="<?= $post['id'] ?>"><i class="fas fa-trash"></i> Delete</button> </td>

                    <div class="nodal js-nodal" id="nodal-<?php echo $post['id']; ?>">
                        <div class="nodal-container js-nodal-container">
                            <form action="../actions/update_post.php" method="POST">
                                <div class="nodal-close js-nodal-close">
                                    <i class="ti-close fas fa-close" id="<?php print $post['id']; ?>"></i>
                                </div>

                                <header class="nodal-header">
                                    Update Post <?php echo $post['id'] ?>
                                </header>

                                <div class="nodal-body">
                                    <input type="hidden" name="submitted2" value="1">
                                    <input type="hidden" name="postId" value="<?= htmlentities($post['id']) ?>">

                                    Title
                                    <input type="text" class="nodal-input" name="title" value="<?= htmlentities($post['title']) ?>" placeholder="Enter Title...">

                                    Level
                                    <select class="nodal-input" name="level">
                                        <option value="Sơ Cấp">Sơ Cấp</option>
                                        <option value="Trung Cấp">Trung Cấp</option>
                                        <option value="Cao Cấp">Cao Cấp</option>
                                    </select>

                                    <div class="input-container">
                                        <label for="experience">Experience</label>
                                        <input required type="text" class="nodal-input" name="experience" value="<?= htmlentities($post['experience']) ?>" placeholder="Enter Experience...">
                                        <div class="error-msg"></div>
                                    </div>

                                    Target
                                    <select class="nodal-input" name="target">
                                        <option value="Giao Tiếp">Giao Tiếp</option>
                                        <option value="Luyện Thi">Luyện Thi</option>
                                        <option value="Business">Business</option>
                                    </select>

                                    <div class="input-container">
                                        <label for="salary">Salary</label>
                                        <input required type="text" class="nodal-input" name="salary" value="<?= htmlentities($post['salary']) ?>" placeholder="Enter Salary...">
                                        <div class="error-msg"></div>
                                    </div>

                                    Address
                                    <input type="text" class="nodal-input" name="address" value="<?= htmlentities($post['address']) ?>" placeholder="Enter Address...">

                                    <div class="input-container">
                                        <label for="phone">Phone</label>
                                        <input required type="text" class="nodal-input" name="phone" value="<?= htmlentities($post['phone']) ?>" placeholder="Enter Phone...">
                                        <div class="error-msg"></div>
                                    </div>

                                    <button id="buy-tickets" type="submit">
                                        Update Post <i class="fas-check"></i>
                                    </button>

                                </div>
                            </form>
                        </div>
                    </div>
                </tr>
            <?php } ?>

        </table>
    </div>


    <!-- Đoạn HTML modal confirm xóa -->
    <div id="deleteConfirmModal" class="cfmodal" style="display: none;">
        <div class="cfmodal-content">
            <p>Are you sure you want to delete this post?</p>
            <button id="confirmDeleteBtn">Delete</button>
            <button id="cancelDeleteBtn">Cancel</button>
        </div>

    </div>

</body>



</html>