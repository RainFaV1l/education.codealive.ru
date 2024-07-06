<form wire:submit.prevent="{{ $funcName }}()" class="admin-panel-info-new-users__form">
    <input wire:model.debounce.500ms="search" type="search" placeholder="{{ $text }}">
    <button type="submit">
        <svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
            <circle cx="6.5" cy="6.5" r="5.75" stroke="#1D1D39" stroke-opacity="0.6" stroke-width="1.5"/>
            <line x1="11.0607" y1="11" x2="16" y2="15.9393" stroke="#1D1D39" stroke-opacity="0.6" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
    </button>
</form>
