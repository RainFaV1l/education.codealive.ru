@props(['number', 'name'])

<div
    x-data="{ isOpen: false }" @click="isOpen = !isOpen"
    class="py-8 px-10 rounded cursor-pointer"
    style="box-shadow: 0 0 15px rgba(0, 0, 0, 0.05), inset 0 0 4px rgba(0, 0, 0, 0.25)">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="rounded-full transition-all duration-300"
                 :style="isOpen ? 'background-color: #FF22B0; height: 17px; width: 17px;' : 'background-color: #6C63FF; height: 17px; width: 17px;'"></div>
            <div class="font-medium" style="font-size: 20px">{{ $item[$number] . '. ' . $item[$name] }}</div>
        </div>
        <div class="transition-all duration-300" :style="isOpen ? 'transform: rotate(180deg);' : 'transform: rotate(0deg);'">
            <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M3.38557 1.22386C2.89539 0.723678 2.08997 0.723751 1.59988 1.22402L1.50696 1.31887C1.03081 1.80492 1.03087 2.58253 1.5071 3.0685L9.08105 10.7975C9.56251 11.2888 10.3505 11.2988 10.8442 10.8199L18.8338 3.06946C19.331 2.58711 19.3411 1.79237 18.8563 1.2975L18.7597 1.1989C18.28 0.709176 17.4953 0.69724 17.0009 1.17214L10.4968 7.41943C10.2002 7.70434 9.72948 7.69722 9.44162 7.40348L3.38557 1.22386Z"
                      :style="isOpen ? 'fill: #FF22B0;' : 'fill: #6C63FF;'"
                      class="transition-all duration-300" />
            </svg>
        </div>
    </div>
    <div class="h-0 opacity-0 overflow-hidden transition-all duration-300 text-base font-medium" x-ref="content"
    :style="isOpen ? 'height: ' + $refs.content.scrollHeight + 'px; overflow: visible; opacity: 1; margin-top: 20px;' : ''">
        {{ $slot }}
    </div>
</div>