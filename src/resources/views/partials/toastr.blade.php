<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, {{ $timeout ?? 3000 }})" role="alert"
    class="fixed top-5 right-5 bg-green-600 text-white text-sm p-4 rounded-lg shadow-lg z-50 {{ $class ?? '' }}">
    <p>{{ $message }}</p>
</div>
