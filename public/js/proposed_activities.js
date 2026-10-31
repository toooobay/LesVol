function toggleDropdown() {
    document.getElementById('my-dropdown').classList.toggle('open');
}
document.addEventListener('click', function (e) {
    if (!e.target.closest('.dropdown-wrapper')) {
        document.getElementById('my-dropdown').classList.remove('open');
    }
});


function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this activity?')) {
        submitWithCsrf('/delete-activity/' + id, 'DELETE');
    }
}

function markAsDone(id) {
    if (confirm('Are you sure you want to mark this activity as done?')) {
        submitWithCsrf('/mark-done-activity/' + id);
    }
}
