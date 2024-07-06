<aside class="admin-panel-content__aside admin-panel-content-aside">
    <div class="admin-panel-vertical-line"></div>
    <a href="{{ route('dashboard.index') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.index') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M24.3333 3C25.8061 3 27 4.17755 27 5.63014L27 10.1199C27 11.5725 25.8061 12.7501 24.3333 12.7501H20.3333C18.8606 12.7501 17.6667 11.5725 17.6667 10.1199L17.6667 5.63014C17.6667 4.17755 18.8606 3 20.3333 3L24.3333 3Z"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M5.66666 3C4.19391 3 3 4.17755 3 5.63014L3.00001 10.1199C3.00001 11.5725 4.19392 12.7501 5.66668 12.7501H9.66668C11.1394 12.7501 12.3333 11.5725 12.3333 10.1199L12.3333 5.63014C12.3333 4.17755 11.1394 3 9.66666 3L5.66666 3Z"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M24.3333 17.2501C25.8061 17.2501 27 18.4276 27 19.8802V24.3699C27 25.8225 25.8061 27.0001 24.3333 27.0001H20.3333C18.8606 27.0001 17.6667 25.8225 17.6667 24.3699L17.6667 19.8802C17.6667 18.4276 18.8606 17.2501 20.3333 17.2501H24.3333Z"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                <path
                    d="M5.66668 17.2501C4.19392 17.2501 3.00001 18.4276 3.00001 19.8802L3.00001 24.3699C3.00001 25.8225 4.19392 27.0001 5.66668 27.0001H9.66668C11.1394 27.0001 12.3333 25.8225 12.3333 24.3699L12.3333 19.8802C12.3333 18.4276 11.1394 17.2501 9.66668 17.2501H5.66668Z"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Информация</p>
    </a>
    <a href="{{ route('dashboard.courses') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.courses') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="28" height="32" viewBox="0 0 28 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M14 31L27 23.5V8.5L14 1L1 8.5V23.5L14 31ZM14 31V16.9375M14 16.9375L1.80348 9.4375M14 16.9375L26.1965 9.4375"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Курсы</p>
    </a>
    <a href="{{ route('dashboard.lessons') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.lessons') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <rect x="1" y="1" width="24" height="24" rx="3" stroke="#1D1D39" stroke-width="2"/>
                <path d="M17 13L11 9.5359V16.4641L17 13Z" stroke="#1D1D39" stroke-width="2"/>
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Уроки</p>
    </a>
    <a href="{{ route('dashboard.categories') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.categories') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M25 12.9689L13 19.1198L1 12.9689M25 18.8491L13 25L1 18.8491M13 1L25 7.15093L13 13.3019L1 7.15093L13 1Z"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Категории</p>
    </a>
    <a href="{{ route('dashboard.users') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.users') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="14.5" cy="7.5" r="4.5" stroke="#1D1D39" stroke-width="2" />
                <path d="M4 28V23C4 20.2386 6.23858 18 9 18H20C22.7614 18 25 20.2386 25 23V28" stroke="#1D1D39"
                    stroke-width="2" />
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Пользователи</p>
    </a>
    <a href="{{ route('dashboard.groups') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.groups') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M20.0318 25.7134L20.0321 21.6962C20.0323 19.4772 18.2335 17.6783 16.0146 17.6783H7.01802C4.79936 17.6783 3.0007 19.4767 3.00045 21.6954L3 25.7134M26.9996 25.7136L27 21.6964C27.0002 19.4774 25.2014 17.6785 22.9824 17.6785M19.2579 5.07564C20.2445 5.80768 20.8839 6.98125 20.8839 8.30416C20.8839 9.62708 20.2445 10.8006 19.2579 11.5327M15.6172 8.30395C15.6172 10.5228 13.8185 12.3215 11.5997 12.3215C9.38084 12.3215 7.58211 10.5228 7.58211 8.30395C7.58211 6.0851 9.38084 4.28638 11.5997 4.28638C13.8185 4.28638 15.6172 6.0851 15.6172 8.30395Z"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Группы</p>
    </a>
    <a href="{{ route('dashboard.applications') }}" data-turbo-preserve-scroll
        class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.applications') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M3 6V24C3 25.6568 4.34314 27 6 27H24C25.6568 27 27 25.6568 27 24V6M3 6C3 4.34315 4.34315 3 6 3H24C25.6568 3 27 4.34315 27 6M3 6C3 7.65685 4.34315 9 6 9H24C25.6568 9 27 7.65685 27 6M8.25 18H14.25M8.25 22.5H12"
                    stroke="#1D1D39" stroke-width="2" stroke-linecap="round" />
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Заявки</p>
    </a>
    <a href="{{ route('dashboard.modules') }}" data-turbo-preserve-scroll
       class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.modules') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                 width="25.000000pt" height="30.000000pt" viewBox="0 0 512.000000 512.000000"
                 preserveAspectRatio="xMidYMid meet" class="modules-svg">
                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                   fill="#1D1D39" stroke="none">
                    <path d="M2010 4884 c-289 -129 -576 -258 -638 -286 -67 -30 -118 -59 -125
                        -72 -9 -16 -13 -222 -17 -825 l-5 -804 -590 -264 c-324 -145 -599 -272 -610
                        -283 -20 -20 -20 -33 -23 -875 l-2 -854 27 -31 c21 -23 178 -97 656 -310 345
                        -154 637 -280 648 -280 12 0 293 121 626 270 l604 270 604 -270 c332 -149 614
                        -270 625 -270 12 0 303 126 648 280 479 214 634 287 655 310 l27 30 0 850 0
                        849 -22 26 c-16 18 -207 108 -613 289 l-590 264 -5 803 c-3 442 -9 812 -14
                        822 -12 24 -18 28 -697 331 -328 146 -607 266 -620 266 -13 -1 -260 -107 -549
                        -236z m1048 -196 c259 -116 472 -214 472 -217 0 -4 -218 -104 -485 -223 l-484
                        -217 -486 217 c-267 119 -485 219 -485 223 0 3 168 81 373 172 204 91 422 189
                        482 216 61 28 117 48 125 45 8 -3 228 -100 488 -216z m-1105 -605 l507 -227 0
                        -131 c0 -146 7 -166 66 -191 29 -12 39 -12 68 0 59 25 66 45 66 191 l0 131
                        508 227 c280 125 512 227 516 227 3 0 5 -318 4 -706 l-3 -706 -510 -228 -510
                        -228 -5 156 c-3 87 -9 165 -14 175 -10 21 -57 47 -85 47 -34 0 -72 -23 -87
                        -51 -10 -21 -14 -68 -14 -178 l0 -150 -32 14 c-18 8 -249 110 -513 228 l-480
                        215 -3 706 c-1 388 1 706 5 706 5 0 236 -102 516 -227z m-149 -1569 c254 -113
                        471 -212 484 -218 21 -11 -20 -32 -462 -229 -267 -119 -490 -217 -495 -217 -8
                        0 -972 428 -979 435 -1 1 165 77 370 168 205 91 423 189 483 216 61 28 116 50
                        124 51 8 0 221 -93 475 -206z m2482 -10 c266 -120 483 -218 481 -220 -14 -15
                        -975 -434 -986 -431 -29 7 -971 430 -967 434 8 9 962 432 974 433 7 0 231 -97
                        498 -216z m-3571 -602 l510 -228 3 -708 c2 -672 1 -708 -15 -702 -10 4 -242
                        107 -515 229 l-498 222 0 708 c0 389 1 707 3 707 1 0 232 -103 512 -228z
                        m1745 -480 l0 -708 -509 -227 c-279 -125 -511 -227 -515 -227 -3 0 -5 318 -4
                        706 l3 707 510 228 c281 126 511 228 513 229 1 0 2 -319 2 -708z m730 472
                        l495 -221 3 -707 c1 -388 0 -706 -4 -706 -3 0 -150 65 -327 144 -177 79 -406
                        181 -509 227 l-188 83 0 708 c0 670 1 707 18 701 9 -4 240 -107 512 -229z
                        m1730 -472 l0 -707 -497 -222 c-274 -122 -506 -225 -516 -229 -16 -6 -17 30
                        -15 701 l3 708 510 228 c281 126 511 229 513 229 1 0 2 -318 2 -708z"/>
                    <path d="M2495 3248 c-56 -49 -40 -134 31 -164 29 -12 39 -12 68 0 102 43 76 186 -34 186 -26 0 -47 -7 -65 -22z"/>
                </g>
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Модули</p>
    </a>
    <a href="{{ route('dashboard.reviews') }}" data-turbo-preserve-scroll
       class="admin-panel-content-aside__item {{ \App\Models\Header::isActiveRoute('dashboard.reviews') }}">
        <div class="admin-panel-content-aside__item-icon">
            <svg class="fill-svg" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1390_3819)">
                    <path fill="#1D1D39" d="M3.45734 0.181641C1.91046 0.585938 0.726869 1.69922 0.217103 3.23438C0.0530407 3.73242 0.0413219 3.84961 0.0354626 4.57031C0.0296032 5.4668 0.105775 5.84766 0.439759 6.54492C0.762025 7.22461 0.949525 7.45898 2.27374 8.80078L3.52765 10.0723L3.26398 10.7051C2.63117 12.2168 2.49054 12.9258 2.49054 14.5898C2.4964 15.6621 2.51398 15.9375 2.62531 16.4473C2.91242 17.7773 3.46906 19.0547 4.20734 20.0977C4.71124 20.8125 5.78937 21.8906 6.50421 22.3945C7.53546 23.127 8.9007 23.7129 10.178 23.9707C10.6819 24.0703 11.0804 24.1055 12.1351 24.1289L13.4593 24.1523L16.5589 27.041L19.6585 29.9238L19.6761 27.041L19.6878 24.1582L20.7015 24.123C22.2132 24.0762 23.4202 23.7773 24.6859 23.1387C28.2835 21.3281 30.3694 17.5254 29.9417 13.5469C29.8128 12.4043 29.4202 11.1094 28.9046 10.1367C28.4241 9.23438 27.9554 8.61328 27.1585 7.81641C26.0218 6.67383 24.8851 5.96484 23.4378 5.48438C22.1956 5.07422 21.3929 4.98047 19.1312 4.98047H17.4612V4.49414C17.4612 3.06445 16.6937 1.65234 15.4573 0.814453C14.6956 0.292969 13.8987 0.0585938 12.8851 0.0585938C11.4964 0.0585938 10.512 0.515625 9.32257 1.72266L8.76593 2.2793L8.1507 1.68164C7.20148 0.761719 6.49835 0.339844 5.57843 0.146484C5.00421 0.0234375 3.9964 0.0410156 3.45734 0.181641ZM5.45538 1.93359C5.64874 2.00391 5.91827 2.12109 6.05304 2.20312C6.18781 2.29102 6.84406 2.90039 7.51202 3.5625L8.73077 4.76953L9.91437 3.5918C10.5706 2.94727 11.2386 2.33203 11.3968 2.23242C11.8831 1.92188 12.3929 1.79883 13.055 1.82812C13.5648 1.8457 13.6702 1.86914 14.0804 2.06836C14.6956 2.35547 15.1585 2.82422 15.4573 3.43945C15.6683 3.89062 15.6741 3.9082 15.6741 4.59961C15.6741 5.42578 15.5687 5.75391 15.1468 6.31055C15.0062 6.49805 13.512 8.02734 11.8245 9.71484L8.76007 12.7734L5.4964 9.50977C2.92999 6.93164 2.20929 6.17578 2.08624 5.93555C1.29523 4.34766 2.06867 2.46094 3.73859 1.92773C4.2132 1.77539 4.99835 1.78125 5.45538 1.93359ZM21.973 6.90234C23.5667 7.25977 24.8148 7.93945 25.928 9.05273C27.0648 10.1836 27.7679 11.5078 28.1077 13.125C28.2484 13.8105 28.2484 15.2988 28.1077 16.0137C27.4925 19.1074 25.1956 21.4746 22.0901 22.2188C21.6624 22.3242 21.3401 22.3418 19.764 22.3652L17.93 22.3945L17.9183 24.1406L17.9007 25.8809L16.0257 24.1348L14.1507 22.3887L12.7444 22.3828C11.139 22.3828 10.5823 22.3125 9.6214 22.002C6.96124 21.1465 4.96906 18.9316 4.36554 16.1719C4.21906 15.498 4.1839 14.0977 4.30109 13.377C4.38312 12.832 4.67609 11.7891 4.81671 11.5195C4.86945 11.4258 5.11554 11.6484 6.80304 13.3359L8.73077 15.2637L12.5921 11.4023C15.5159 8.47852 16.512 7.44727 16.7054 7.14258L16.9632 6.73828L19.1898 6.76172C21.1937 6.7793 21.4749 6.79102 21.973 6.90234Z"/>
                    <path fill="#1D1D39" d="M11.4258 14.9414V15.8203H12.3633H13.3008V14.9414V14.0625H12.3633H11.4258V14.9414Z" />
                    <path fill="#1D1D39" d="M15.5273 14.9414V15.8203H16.4648H17.4023V14.9414V14.0625H16.4648H15.5273V14.9414Z" />
                    <path fill="#1D1D39" d="M19.6289 14.9414V15.8203H20.5664H21.5039V14.9414V14.0625H20.5664H19.6289V14.9414Z"/>
                </g>
                <defs>
                    <clipPath id="clip0_1390_3819">
                        <rect width="30" height="30" fill="white"/>
                    </clipPath>
                </defs>
            </svg>
        </div>
        <p class="admin-panel-content-aside__item__name">Отзывы</p>
    </a>
</aside>
