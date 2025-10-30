@props([
    'asChild' => false,
])

@php
if (!$asChild) {
    $classes = 'inline-flex items-center justify-center rounded-md p-2 text-muted-foreground hover:text-foreground hover:bg-muted transition-colors';
}
@endphp

<div
    x-data="{
        modal: null,
        modalName: null,
        init() {
            this.modal = this.$el.closest('[data-strata-modal]');
            if (this.modal) {
                this.modalName = this.modal.getAttribute('data-modal-name');
            }
        },
        close() {
            if (this.modal) {
                this.modal.close();
            }
        }
    }"
    @click="close()"
    data-strata-modal-close
    {{ $attributes->merge(!$asChild ? ['class' => $classes] : []) }}
>
    @if($slot->isEmpty() && !$asChild)
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
        </svg>
        <span class="sr-only">Close</span>
    @else
        {{ $slot }}
    @endif
</div>
