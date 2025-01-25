<nav class="main-header">
    <div class="navbar-left">
        <button class="sidebar-toggle"><i class='bx bx-menu'></i></button>
    </div>
    <div class="navbar-right">
        <a href="#" class="nav-link notification-bell">
            <i class='bx bxs-bell'></i>
            <span class="notification-count" style="display: none;">0</span>
        </a>
        <div class="notification-dropdown">
            <div class="notification-header">
                Notifications
            </div>
            <div class="notification-list">
                <!-- Notifications will be appended here -->
            </div>
        </div>
        <a href="#" class="nav-link user-menu">
            <i class='bx bxs-user-circle'></i>
            <span class="user-name">{{ Auth::user()->name }}</span>
        </a>
        <div class="user-dropdown">
            <div class="user-dropdown-header">
                <i class='bx bxs-user-circle'></i>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-email">{{ Auth::user()->email }}</span>
                </div>
            </div>
            <hr>
            <a href="{{ route('profile.edit') }}">
                <i class='bx bxs-user'></i> My Profile
            </a>
            <hr>
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class='bx bx-log-out'></i> Logout
                </a>
            </form>
        </div>
    </div>
</nav>

<!-- Add the audio element -->
<audio id="notification-sound" src="{{ asset('tone/notif.mp3') }}"></audio>




<style>
    .navbar-right {
    display: flex;
    align-items: center;
}

.user-menu {
    display: flex;
    align-items: center;
    gap: 8px;
}

.user-name {
    font-size: 14px;
    display: none;
}

@media (min-width: 768px) {
    .user-name {
        display: inline;
    }
}

.user-dropdown {
    min-width: 200px;
    padding: 8px 0;
}

.user-dropdown-header {
    display: flex;
    align-items: center;
    padding: 8px 15px;
    gap: 10px;
}

.user-dropdown-header i {
    font-size: 32px;
    color: #ffd700;
}

.user-info {
    display: flex;
    flex-direction: column;
}

.user-info .user-name {
    font-weight: 500;
    display: block;
}

.user-info .user-email {
    font-size: 12px;
    color: #666;
}

.user-dropdown hr {
    margin: 8px 0;
}

.user-dropdown a {
    padding: 8px 15px;
}

.user-dropdown form {
    margin: 0;
}

.user-dropdown form a {
    color: #dc3545;
}

.user-dropdown form a:hover {
    background-color: #fff1f1;
}

.notification-dropdown {
    display: none;
    position: absolute;
    top: 40px;
    right: 0;
    width: 250px; /* Make it smaller */
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    border-radius: 4px;
    overflow: hidden;
}

.notification-header {
    padding: 10px;
    background-color: #f8f9fa;
    border-bottom: 1px solid #ddd;
    font-weight: bold;
}

.notification-list {
    max-height: 200px; /* Adjust the height as needed */
    overflow-y: auto; /* Add scrollbar */
}

.notification-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
}

.notification-item:hover {
    background-color: #f1f1f1;
}

.notification-item.read {
    background-color: #f8f9fa;
}

.notification-count {
    margin-left: 5px;
    background-color: #dc3545;
    color: #fff;
    font-size: 12px;
    padding: 2px 5px;
    border-radius: 50%;
}




</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const notificationBell = document.querySelector('.notification-bell');
    const notificationDropdown = document.querySelector('.notification-dropdown');
    const notificationList = document.querySelector('.notification-list');
    const notificationCount = document.querySelector('.notification-count');
    const notificationSound = document.getElementById('notification-sound');
    let soundPlayed = false; // Flag to track if the sound has been played

    // Fetch notifications and update the count when the page loads
    fetchNotifications();

    notificationBell.addEventListener('click', function() {
        notificationDropdown.style.display = notificationDropdown.style.display === 'block' ? 'none' : 'block';
        fetchNotifications();
    });

    function fetchNotifications() {
        fetch('/notifications')
            .then(response => response.json())
            .then(data => {
                notificationList.innerHTML = '';
                let unreadCount = 0;
                data.forEach(notification => {
                    const notificationItem = document.createElement('div');
                    notificationItem.classList.add('notification-item');
                    if (notification.read) {
                        notificationItem.classList.add('read');
                    } else {
                        unreadCount++;
                    }
                    notificationItem.innerHTML = `<p>${notification.message}</p>`;
                    notificationItem.addEventListener('click', function() {
                        markAsRead(notification.id);
                    });
                    notificationList.appendChild(notificationItem);
                });
                updateNotificationCount(unreadCount);
                if (unreadCount > 0 && !soundPlayed) {
                    playNotificationSound();
                    soundPlayed = true; // Set the flag to true after playing the sound
                }
            });
    }

    function markAsRead(id) {
        fetch(`/notifications/${id}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                fetchNotifications();
            }
        });
    }

    function updateNotificationCount(count) {
        if (count > 0) {
            notificationCount.textContent = count;
            notificationCount.style.display = 'inline';
        } else {
            notificationCount.style.display = 'none';
        }
    }

    function playNotificationSound() {
        notificationSound.play();
    }
});


</script>
