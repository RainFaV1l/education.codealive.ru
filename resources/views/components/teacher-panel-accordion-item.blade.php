@props(['group', 'number', 'name', 'teacher', 'course_id', 'isPassed'])

<div x-data="{ isOpen: false }" @click="isOpen = !isOpen" class="py-8 px-10 rounded cursor-pointer" style="box-shadow: 0 0 15px rgba(0, 0, 0, 0.05), inset 0 0 4px rgba(0, 0, 0, 0.25)">
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-5">
            <div class="rounded-full transition-all duration-300"
                 :style="isOpen ? 'background-color: #FF22B0; height: 17px; width: 17px;' : 'background-color: #6C63FF; height: 17px; width: 17px;'"></div>
            <div class="font-medium"
                 style="font-size: 20px">{{ $group[$name] . ' (Модуль ' . $group[$number] . ')' }}</div>
        </div>
        <div class="flex items-center gap-7">
            @if($group->isPassedModuleTrait($group->module_id))
                <div class="status">
                    <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="0.5" width="35" height="35" rx="17.5" fill="#51C853"/>
                        <path d="M16.5 22.4L12.5 18.4L13.9 17L16.5 19.6L23.1 13L24.5 14.4L16.5 22.4Z" fill="white"/>
                    </svg>
                </div>
            @endif
            <a href="{{ route('teacher-panel.group', [$course_id, $group->group_id, $group->module_id]) }}"
               class="play">
                <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="18" cy="17.5" r="17.5" fill="#6C63FF" class="play-fill"/>
                    <path d="M24 18.366C24.6667 17.9811 24.6667 17.0189 24 16.634L15.75 11.8708C15.0833 11.4859 14.25 11.9671 14.25 12.7369V22.2631C14.25 23.0329 15.0833 23.5141 15.75 23.1292L24 18.366Z"
                          fill="white"/>
                </svg>
            </a>
            <div class="transition-all duration-300"
                 :style="isOpen ? 'transform: rotate(180deg);' : 'transform: rotate(0deg);'">
                <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M3.38557 1.22386C2.89539 0.723678 2.08997 0.723751 1.59988 1.22402L1.50696 1.31887C1.03081 1.80492 1.03087 2.58253 1.5071 3.0685L9.08105 10.7975C9.56251 11.2888 10.3505 11.2988 10.8442 10.8199L18.8338 3.06946C19.331 2.58711 19.3411 1.79237 18.8563 1.2975L18.7597 1.1989C18.28 0.709176 17.4953 0.69724 17.0009 1.17214L10.4968 7.41943C10.2002 7.70434 9.72948 7.69722 9.44162 7.40348L3.38557 1.22386Z"
                          :style="isOpen ? 'fill: #FF22B0;' : 'fill: #6C63FF;'"
                          class="transition-all duration-300"/>
                </svg>
            </div>
        </div>
    </div>
    <div class="h-0 opacity-0 overflow-hidden transition-all duration-300 text-base font-medium" x-ref="content"
         :style="isOpen ? 'height: ' + $refs.content.scrollHeight + 'px; overflow: visible; opacity: 1; margin-top: 20px;' : ''">
        {{ $slot }}
    </div>
</div>