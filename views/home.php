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
                    <input required type="text" class="modal-input" name="title" value="" placeholder="Enter Title...">

                    Level
                    <select required class="nodal-input" name="level">
                        <option value="Sơ Cấp">Sơ Cấp</option>
                        <option value="Trung Cấp">Trung Cấp</option>
                        <option value="Cao Cấp">Cao Cấp</option>
                    </select>

                    <div class="input-container">
                        <label for="experience">Experience</label>
                        <input required type="text" class="modal-input" name="experience" value="" placeholder="Enter Experience...">
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
                        <input required type="text" class="modal-input" name="salary" value="" placeholder="Enter Salary...">
                        <div class="error-msg"></div>
                    </div>
                    Address
                    <input required type="text" class="modal-input" name="address" value="" placeholder="Enter Address...">

                    <div class="input-container">
                        <label for="phone">Phone</label>
                        <input required type="text" class="modal-input" name="phone" value="" placeholder="Enter Phone...">
                        <div class="error-msg"></div>
                    </div>
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

        const createPostForm = document.querySelector('.js-modal-container form');

        createPostForm.addEventListener('submit', function(event) {
            const phoneInput = createPostForm.querySelector('[name="phone"]');
            const experienceInput = createPostForm.querySelector('[name="experience"]');
            const salaryInput = createPostForm.querySelector('[name="salary"]');

            const phoneValue = phoneInput.value.trim();
            const experienceValue = experienceInput.value.trim();
            const salaryValue = salaryInput.value.trim();

            let isValid = true;

            if (!isValidPhoneNumber(phoneValue)) {
                event.preventDefault();
                showFieldError(phoneInput, 'Invalid phone number.');
                isValid = false;
            }

            if (!isValidNumber(experienceValue)) {
                event.preventDefault();
                showFieldError(experienceInput, 'Experience must be a valid number.');
                isValid = false;
            }

            if (!isValidNumber(salaryValue)) {
                event.preventDefault();
                showFieldError(salaryInput, 'Salary must be a valid number.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

        function isValidPhoneNumber(phone) {
            return /^\d{10}$/.test(phone);
        }

        function isValidNumber(value) {
            return !isNaN(value) && value !== '';
        }

        function showFieldError(inputElement, errorMessage) {
            const parentContainer = inputElement.closest('.input-container');
            const errorElement = parentContainer.querySelector('.error-msg');
            errorElement.textContent = errorMessage;
            errorElement.style.display = 'block';
        }

        function clearFieldError(inputElement) {
            const parentContainer = inputElement.closest('.input-container');
            const errorElement = parentContainer.querySelector('.error-msg');
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    </script>
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
                    <td class="tittle"><?php echo $post['id']; ?></td>
                    <td class="tittle"><?php echo $post['title']; ?></td>
                    <td class="tittle"><?php echo $post['level']; ?></td>
                    <td class="tittle"><?php echo $post['experience']; ?></td>
                    <td class="tittle"><?php echo $post['target']; ?></td>
                    <td class="tittle"><?php echo $post['salary']; ?></td>
                    <td class="tittle"><?php echo $post['address']; ?></td>
                    <td class="tittle"><?php echo $post['phone']; ?></td>
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
        const updatePostForm = document.querySelector('.js-nodal-container');

        updatePostForm.addEventListener('submit', function(event) {
            const phoneInput = updatePostForm.querySelector('[name="phone"]');
            const experienceInput = updatePostForm.querySelector('[name="experience"]');
            const salaryInput = updatePostForm.querySelector('[name="salary"]');

            const phoneValue = phoneInput.value.trim();
            const experienceValue = experienceInput.value.trim();
            const salaryValue = salaryInput.value.trim();

            let isValid = true;

            if (!isValidPhoneNumber(phoneValue)) {
                event.preventDefault();
                showFieldError(phoneInput, 'Invalid phone number.');
                isValid = false;
            }

            if (!isValidNumber(experienceValue)) {
                event.preventDefault();
                showFieldError(experienceInput, 'Experience must be a valid number.');
                isValid = false;
            }

            if (!isValidNumber(salaryValue)) {
                event.preventDefault();
                showFieldError(salaryInput, 'Salary must be a valid number.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

        function isValidPhoneNumber(phone) {
            return /^\d{10}$/.test(phone);
        }

        function isValidNumber(value) {
            return !isNaN(value) && value !== '';
        }

        function showFieldError(inputElement, errorMessage) {
            const parentContainer = inputElement.closest('.input-container');
            const errorElement = parentContainer.querySelector('.error-msg');
            errorElement.textContent = errorMessage;
            errorElement.style.display = 'block';
        }

        function clearFieldError(inputElement) {
            const parentContainer = inputElement.closest('.input-container');
            const errorElement = parentContainer.querySelector('.error-msg');
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    </script>
    <!-- Đoạn HTML modal confirm xóa -->
    <div id="deleteConfirmModal" class="cfmodal">

        <div class="cfmodal-content">
            <p>Are you sure you want to delete this post?</p>
            <button id="confirmDeleteBtn">Delete</button>
            <button id="cancelDeleteBtn">Cancel</button>
        </div>

    </div>
    <script>
        const deleteBtns = document.querySelectorAll('.js-delete-post');
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');
        let postIdToDelete = null;

        function showDeleteConfirmModal(postId) {
            postIdToDelete = postId;
            deleteConfirmModal.style.display = 'flex';
        }

        function hideDeleteConfirmModal() {
            postIdToDelete = null;
            deleteConfirmModal.style.display = 'none';
        }

        function deletePost(postId) {
            fetch(`../actions/delete_post.php?id=${postId}`, {
                    method: 'DELETE'
                }).then(response => {
                    response.json();
                    const deletedRow = document.querySelector(`[data-post-id="${postId}"]`).closest('tr');
                    deletedRow.remove();
                })
                .catch(error => console.error(error));
            hideDeleteConfirmModal();
        }
        hideDeleteConfirmModal();
        for (const deleteBtn of deleteBtns) {
            deleteBtn.addEventListener('click', () => {
                const postId = deleteBtn.getAttribute('data-post-id');
                showDeleteConfirmModal(postId);
            });
        }

        confirmDeleteBtn.addEventListener('click', () => {
            if (postIdToDelete) {
                deletePost(postIdToDelete);
            }
        });

        cancelDeleteBtn.addEventListener('click', () => {
            hideDeleteConfirmModal();
        });
    </script>


</body>



</html>