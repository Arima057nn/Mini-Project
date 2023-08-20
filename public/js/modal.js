

//////////////////////////////////////////////////////////////

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


///////////////////////////////////////////////////////////////

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
