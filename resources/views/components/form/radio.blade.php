<div class="relative flex items-start">
    <div class="flex items-center h-5">
        <input
            id="{{ $id }}"
            name="{{ $name }}"
            type="radio"
            value="{{ $value }}"
            @if($checked) checked @endif
            {{ $attributes }}
            class="h-4 w-4 text-primary-600 border-muted focus:outline-hidden focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 bg-white dark:bg-gray-900"
        >
    </div>
    <div class="ml-3 text-sm">
        <label for="{{ $id }}" class="font-medium text-primary cursor-pointer">
            {{ $label }}
        </label>
        @if($description)
            <p class="text-xs text-muted mt-0.5">{{ $description }}</p>
        @endif
    </div>
</div>