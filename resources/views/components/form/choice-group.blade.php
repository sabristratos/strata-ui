<fieldset>
    <legend class="text-sm font-medium text-primary mb-3">{{ $label }}</legend>
    <div class="space-y-3 @if($inline) sm:flex sm:space-y-0 sm:space-x-6 @endif">
        {{ $slot }}
    </div>
</fieldset>