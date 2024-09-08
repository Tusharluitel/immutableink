<!DOCTYPE html>
<html>
<head>
    <title>File Dashboard</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    @vite('resources/css/app.css')

</head>
<body class="bg-gray-100 flex flex-col items-center min-h-screen">
    <div class="container mx-auto p-6 bg-white rounded-lg shadow-lg w-full max-w-4xl">
        <h1 class="text-2xl font-semibold mb-4">File Dashboard</h1>

        <a href="{{ route('files.create') }}" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600 mb-4 inline-block">Upload New File</a>

        <form action="{{ route('logout') }}" method="POST" class="mb-4">
            @csrf
            <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">Logout</button>
        </form>

        @if ($files->count())
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Link</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Uploaded At</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($files as $file)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ basename($file->file) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ $file->link }}" target="_blank" class="text-blue-500 hover:underline">{{ $file->link }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $file->created_at->format('M d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-4">
                {{ $files->links() }}
            </div>
        @else
            <p class="text-gray-500">No files found.</p>
        @endif
    </div>

    <!-- Snackbar -->
    <div id="snackbar" class="fixed bottom-0 left-1/2 transform -translate-x-1/2 mb-4 px-4 py-2 rounded text-white bg-green-500 hidden">
        <span id="snackbar-message"></span>
    </div>
    
    <div id="snackbar-error" class="fixed bottom-0 left-1/2 transform -translate-x-1/2 mb-4 px-4 py-2 rounded text-white bg-red-500 hidden">
        <span id="snackbar-message-error"></span>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            @if(session('success'))
                showSnackbar('{{ session('success') }}', 'success');
            @elseif(session('error'))
                showSnackbar('{{ session('error') }}', 'error');
            @endif
        });

        function showSnackbar(message, type) {
            const snackbar = type === 'success' ? document.getElementById('snackbar') : document.getElementById('snackbar-error');
            const snackbarMessage = type === 'success' ? document.getElementById('snackbar-message') : document.getElementById('snackbar-message-error');
            
            snackbarMessage.textContent = message;
            snackbar.classList.remove('hidden');
            setTimeout(() => {
                snackbar.classList.add('hidden');
            }, 3000);
        }
    </script>
</body>
</html>
