document.addEventListener('DOMContentLoaded', function () {
    const teacherSearch = document.getElementById('teacher_search');
    const adminList = document.getElementById('adminList');
    const teacherId = document.getElementById('teacher_id');
    const comments = document.getElementById('comments');
    const nextButton = document.querySelector('button[type="submit"]');
    const charCount = document.getElementById('charCount');

    // Function to check if both the purpose field is filled out and an admin is selected
    function checkFormValidity() {
        const purposeFilled = comments.value.trim() !== '';
        const adminSelected = teacherId.value.trim() !== '';
        nextButton.disabled = !(purposeFilled && adminSelected);
        // Update character count
        charCount.textContent = `${comments.value.length}/100 characters`;
    }

    // Initial check
    checkFormValidity();

    // Event listener for the purpose field
    comments.addEventListener('input', checkFormValidity);

    // Event listener for the admin search field
    teacherSearch.addEventListener('input', function () {
        const query = teacherSearch.value;
        if (query.length > 0) {
            fetch(`/search-admins?query=${query}`)
                .then(response => response.json())
                .then(data => {
                    adminList.innerHTML = '';
                    adminList.style.display = 'block';
                    data.forEach(admin => {
                        const listItem = document.createElement('a');
                        listItem.href = '#';
                        listItem.className = 'list-group-item list-group-item-action';
                        listItem.textContent = `${admin.name} ${admin.last_name} (${admin.role.role_name})`;
                        listItem.addEventListener('click', function () {
                            teacherSearch.value = `${admin.name} ${admin.last_name} (${admin.role.role_name})`;
                            teacherId.value = admin.id;
                            adminList.style.display = 'none';
                            checkFormValidity(); // Check validity after selecting an admin
                        });
                        adminList.appendChild(listItem);
                    });
                });
        } else {
            adminList.style.display = 'none';
            teacherId.value = ''; // Clear the selected admin if the search bar is empty
            checkFormValidity(); // Check validity after clearing the admin
        }
    });
});
