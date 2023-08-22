export function createFormScript() {
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
}

///////////////////////////////////////////////////////////////////////////

export function updateFormScript() {
    const buyBtns2 = document.querySelectorAll('.js-buy-ticket2')
    const nodal = document.querySelector('.js-nodal')
    // console.log(nodal)
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
}

///////////////////////////////////////////////////////////////////////////

export function deleteFormScript() {
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
    hideDeleteConfirmModal();
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
}