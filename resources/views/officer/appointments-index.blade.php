<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .alert {
            transition: opacity 0.3s ease-in-out;
        }
        .alert.hide {
            opacity: 0;
        }
        .badge {
            padding: 0.25em 0.5em;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-success {
            background-color: #10B981;
            color: #ffffff;
        }
        .badge-destructive {
            background-color: #EF4444;
            color: #ffffff;
        }
        .btn-group {
            display: flex;
            gap: 0.5rem;
        }
        .btn {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            font-size: 0.875rem;
            line-height: 1.25rem;
            transition: background-color 0.2s;
        }
        .btn-primary {
            background-color: #2563EB;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #1D4ED8;
        }
        .btn-secondary {
            background-color: #6B7280;
            color: #ffffff;
        }
        .btn-secondary:hover {
            background-color: #4B5563;
        }
        .btn-destructive {
            background-color: #EF4444;
            color: #ffffff;
        }
        .btn-destructive:hover {
            background-color: #DC2626;
        }
        .btn-icon {
            padding: 0.5rem;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-4 space-y-4 max-w-7xl">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold tracking-tight">Manage Appointments</h1>
            <a href="/officer/appointments/create" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" class="inline-block w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Create New Appointment
            </a>
        </div>

        <div id="successAlert" class="alert bg-green-50 text-green-900 border border-green-200 p-4 rounded-md hidden" role="alert">
            Operation completed successfully
        </div>

        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-4">Appointments List</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Available Slots</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">May 15, 2024</td>
                                <td class="px-6 py-4 whitespace-nowrap">2:00 PM</td>
                                <td class="px-6 py-4 whitespace-nowrap">30 minutes</td>
                                <td class="px-6 py-4 whitespace-nowrap">Career Counseling</td>
                                <td class="px-6 py-4 whitespace-nowrap">3/5</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="badge badge-success">Available</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="btn-group">
                                        <a href="/officer/appointments/1/edit" class="btn btn-secondary btn-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <button class="btn btn-destructive btn-icon" onclick="handleDelete(1)">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <!-- Additional appointments here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        function handleDelete(id) {
            if (confirm('Are you sure you want to delete this appointment?')) {
                // In a real app, you would make an API call here
                console.log('Deleting appointment with id:', id);
                showSuccessAlert();
            }
        }

        function showSuccessAlert() {
            const alert = document.getElementById('successAlert');
            alert.classList.remove('hidden');
            setTimeout(() => {
                alert.classList.add('hide');
                setTimeout(() => {
                    alert.classList.add('hidden');
                    alert.classList.remove('hide');
                }, 300);
            }, 3000);
        }
    </script>
</body>
</html>
