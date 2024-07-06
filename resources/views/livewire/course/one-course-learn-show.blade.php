<div class="content">
    <div class="title-two">
        <div class="text">
            <h1>{{ $course['name'] }}</h1>
            <p>{{ $course->level['name'] }} курс</p>
        </div>
        <div class="line"></div>
    </div>
    <div class="one-course-banner">
        <div class="one-course__banner">
            <div class="one-course__logo">Паутина</div>
            <div class="one-course__banner-info">
                <div class="one-course__name">
                    <h1>{{ $course->name }}</h1>
                    <div class="text">
                        {{ $course->level['name'] }} курс
                    </div>
                </div>
                <div class="author">
                    <div class="author__ava">
                        @if (!$course->user->user_url)
                        <img src="{{ $course->user->user_url }}" alt="Аватарка автора">
                        @else
                        <img src="{{ asset('assets/avatar/gamer.png') }}" alt="Стандартная аватарка автора">
                        @endif
                    </div>
                    <div class="author__name">
                        <div class="name">{{ $course->user->name . ' ' . $course->user->surname }}
                        </div>
                        {{-- <div class="post">Ведущий Frontend-разработчик Pautina</div> --}}
                    </div>
                </div>
            </div>
            <div class="one-course__banner-img">
                <img src="{{ asset('assets/img/one-course-remove-bg.png') }}" alt="Изображение">
            </div>
        </div>
    </div>
    <div class="one-course__nav">
        <div class="category-nav" x-data="{ active: 0 }">
            @if (\Illuminate\Support\Facades\Auth::user()->role_id === 1)
            <a @click="active=0" :class="active === 0 ? 'active' : ''" wire:click.prevent="all()">Все</a>
            <a @click="active=1" :class="active === 1 ? 'active' : ''" wire:click.prevent="active({{ $group_modules }})">Активные</a>
            <a @click="active=2" :class="active === 2 ? 'active' : ''" wire:click.prevent="completed({{ $group_modules }})">Завершенные</a>

            {{-- @elseif(\Illuminate\Support\Facades\Auth::user()->role_id === 2)--}}
            {{-- <a href="#" class="active">Все</a>--}}
            {{-- <a href="#">Активные</a>--}}
            {{-- <a href="#">Завершенные</a>--}}
            @elseif(\Illuminate\Support\Facades\Auth::user()->role_id === 3)
            <a href="{{ route('lessons.addId', $course['id']) }}" class="darkerBlueFill__button admin-panel-info-groups__button">Добавить
                урок</a>
            @endif
            @php

            // Создание экземпляра сервиса курса
            $courseService = new \App\Services\Course\Service();

            @endphp

            @if($courseService->checkCertificateQuery($course->id, auth()->user()->id))
            <a href="{{ route('courses.gift', $course->id) }}">Страница сертификата</a>
            @endif
        </div>
        <div class="courses">
            @php
            if(isset($disabled_modules)) {
            $allLesson = 0;
            foreach ($disabled_modules as $disabled_module) {
            $allLessonCount = \App\Models\LessonModule::query()->where('lesson_modules.module_id', '=', $disabled_module->id)->get();
            $allLesson = $allLesson + $allLessonCount->count();
            }
            }
            @endphp
            Всего уроков:
            @if(isset($result['allLessonsCount']) and $result['allLessonsCount'] !== 0)
            {{ $result['allLessonsCount'] }}
            @else
            @if(isset($allLesson))
            {{ $allLesson }}
            @else
            0
            @endif
            @endif
        </div>
    </div>
    <div class="progress-bar">
        <div class="progress-bar__meaning">
            <p>Прогресс:</p>
            <div class="meaning">{{ $percent }}%</div>
        </div>
        <div class="scale">
            <div class="scale__item" style="width: {{ $percent }}%"></div>
        </div>
    </div>
    <div class="one-course__course-wrapper">
        <div class="courses__item">
            <div class="one">
                <div class="name">
                    <div class="course-cat-lev-row">
                        <p>{{ $course->level['name'] }} курс</p>
                    </div>
                    <h2>{{ $course['name'] }}</h2>
                </div>
                <div class="play">
                    <div class="continue">
                        <div class="play-button">
                            <svg width="70" height="70" viewBox="0 0 70 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="35" cy="35" r="35" fill="url(#paint0_linear_573_3652{{ $course->id }})" />
                                <path d="M48.5 35.866C49.1667 35.4811 49.1667 34.5189 48.5 34.134L29 22.8756C28.3333 22.4907 27.5 22.9719 27.5 23.7417V46.2583C27.5 47.0281 28.3333 47.5093 29 47.1244L48.5 35.866Z" fill="white" />
                                <defs>
                                    <linearGradient id="paint0_linear_573_3652{{ $course->id }}" x1="0" y1="0" x2="70" y2="70" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#F8A4D8" />
                                        <stop offset="1" stop-color="#6C63FF" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        @if(isset($course_modules) and isset($learnedModuleCount) and $group_modules->count() !== 0)
                        <div class="text">
                            <div class="number-course">Вы прошли {{ $learnedModuleCount }} из {{ $group_modules->count() }}
                                {{ App\Models\CourseUser::formatCount($group_modules->count(), true, false, true) }}
                            </div>
                        </div>
                        @elseif(isset($disabled_modules))
                        <div class="text">
                            <div class="number-course">
                                Вы прошли {{ $learnedModuleCount }} из {{ $disabled_modules->count() }}
                                {{ App\Models\CourseUser::formatCount($disabled_modules->count(), true, false, true) }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="two">
                <div class="lessons">
                    <div class="item">
                        <img src="{{ asset('assets/img/mini-play.svg') }}" alt="Иконка">
                        @if(isset($result) and $result['allLessonsCount'] !== 0)
                        <p>
                            Пройдено {{ $result['allLearnedLessonsCount'] }} / {{ $result['allLessonsCount'] }}
                            {{ App\Models\CourseUser::formatCount($result['allLessonsCount'], true, false, false, true) }}
                        </p>
                        @elseif(isset($allLesson))
                        <p>
                            Пройдено {{ $result['allLearnedLessonsCount'] }} / {{ $allLesson }}
                            {{ App\Models\CourseUser::formatCount($allLesson, true, false, false, true) }}
                        </p>
                        @else
                        <p>Пройдено 0 / 0 уроков</p>
                        @endif
                    </div>
                    {{-- <div class="item">--}}
                    {{-- Категория - {{ $course->category['name'] }}--}}
                    {{-- </div>--}}
                </div>
                <div class="continue-training">
                    <p>Категория - {{ $course->category['name'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="one-course__wrapper">
        @if(isset($disabled_modules))
        <div class="module-lessons-title">
            <h3 class="module-name show-disabled">Уроки недоступны. Дождитесь пока вас добавят в группу.</h3>
            @foreach($course->lessons as $lesson)
            <div class="program-themes__item none">
                <div class="program-themes__wrapper">
                    <div class="info">
                        <div class="circle none"></div>
                        <div class="name">{{ $lesson['lesson_number'] . '. ' . $lesson['name'] }}</div>
                    </div>
                    <div class="program-theme__end">
                        <div class="arrow none">
                            <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3.38557 1.22386C2.89539 0.723678 2.08997 0.723751 1.59988 1.22402L1.50696 1.31887C1.03081 1.80492 1.03087 2.58253 1.5071 3.0685L9.08105 10.7975C9.56251 11.2888 10.3505 11.2988 10.8442 10.8199L18.8338 3.06946C19.331 2.58711 19.3411 1.79237 18.8563 1.2975L18.7597 1.1989C18.28 0.709176 17.4953 0.69724 17.0009 1.17214L10.4968 7.41943C10.2002 7.70434 9.72948 7.69722 9.44162 7.40348L3.38557 1.22386Z" fill="#6C63FF" class="arcol none" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="about ">
                    {{ $lesson['description'] }}
                </div>
            </div>
            @endforeach
        </div>
        @elseif(isset($course_modules))
        <div class="course-modules__gap">
            @foreach ($course_modules as $course_module)
            @php

            $lessonModules = \App\Models\LessonModule::query()
            ->join('group_modules', 'lesson_modules.module_id', '=', 'group_modules.id')
            ->where('group_modules.course_id', '=', $course_module->course_id)
            ->where('group_modules.group_id', '=', $course_module->group_id)
            ->where('group_modules.id', '=', $course_module->module_id)
            ->get();

            $lessonModulesCount = $lessonModules->count();

            $lessonLearnedModules = \App\Models\LessonModule::query()
            ->join('group_modules', 'lesson_modules.module_id', '=', 'group_modules.id')
            ->join('lesson_users', 'lesson_modules.lesson_id', '=', 'lesson_users.lesson_id')
            ->where('group_modules.course_id', '=', $course_module->course_id)
            ->where('group_modules.group_id', '=', $course_module->group_id)
            ->where('group_modules.id', '=', $course_module->module_id)
            ->where('lesson_users.user_id', '=', \Illuminate\Support\Facades\Auth::user()->id)
            ->where('lesson_users.lesson_users_status_id', '=', 3)
            ->get();

            $lessonLearnedModulesCount = $lessonLearnedModules->count();

            if($lessonLearnedModulesCount === $lessonModulesCount and $lessonModulesCount !== 0 and $lessonLearnedModulesCount !== 0) {
            $state = 'Завершен';
            } else {
            $state = 'Активен';
            }

            @endphp
            <div wire:key="{{ $course_module->id }}" class="module-lessons-title">
                <h3 class="module-name @if($state === 'Завершен') completed @endif">Модуль {{ $course_module->module_number }} ({{ $state }})</h3>
                @php
                // Инициализация сервиса
                $courseService = new \App\Services\Course\Service();
                // Получение уроков модуля
                $module_lessons = $courseService->moduleLessonsQuery($course_module);


                //$module_lessons = \App\Models\LessonModule::query()
                //->select('lessons.id as lesson_id', 'lessons.name',
                //'lessons.description', 'lessons.task', 'lessons.lesson_number')
                //->leftJoin('user_modules', 'user_modules.module_id', '=', 'lesson_modules.module_id')
                //->leftJoin('lessons', 'lesson_modules.lesson_id', '=', 'lessons.id')
                //->where('lesson_modules.module_id', '=', $course_module->module_id)
                //->where('user_modules.student_id', '=', auth()->user()->id)
                //->where('user_modules.module_id', '=', $course_module->module_id)
                //->groupBy('lessons.id')
                //->get();


                @endphp
                @foreach($module_lessons as $lesson)
                @php

                // Проверка пройден ли урок
                $lessonStatusCheck = $courseService->lessonStatusCheck($lesson->lesson_id, auth()->user()->id, 3);

                @endphp

                <div class="program-themes__item ">
                    <div class="program-themes__wrapper">
                        <div class="info">
                            <div class="circle "></div>
                            <div class="name">{{ $lesson->lesson->lesson_number . '. ' . $lesson->lesson->name }}</div>
                        </div>
                        <div class="program-theme__end">
                            @if($lessonStatusCheck->count() !== 0)
                            @php
                            $lessonStatusCheck = $lessonStatusCheck[0];
                            @endphp
                            @if($lessonStatusCheck->lesson_users_status_id === 3)
                            <div class="status">
                                <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect x="0.5" width="35" height="35" rx="17.5" fill="#51C853" />
                                    <path d="M16.5 22.4L12.5 18.4L13.9 17L16.5 19.6L23.1 13L24.5 14.4L16.5 22.4Z" fill="white" />
                                </svg>
                            </div>
                            @elseif($lessonStatusCheck->lesson_users_status_id === 2)
                            <div class="status">
                                <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="17.5" cy="17.5" r="17.5" fill="#FCD425" />
                                    <line x1="13" y1="11.4999" x2="13" y2="23.4999" stroke="white" stroke-width="3" stroke-linecap="round" />
                                    <line x1="21" y1="11.4999" x2="21" y2="23.4999" stroke="white" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </div>
                            @endif
                            @endif
                            <a href="{{ route('lessons.more', [$course_module->module_id, $lesson->lesson_id]) }}" class="play lesson-play">
                                <svg width="36" height="35" viewBox="0 0 36 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="18" cy="17.5" r="17.5" fill="#6C63FF" class="play-fill" />
                                    <path d="M24 18.366C24.6667 17.9811 24.6667 17.0189 24 16.634L15.75 11.8708C15.0833 11.4859 14.25 11.9671 14.25 12.7369V22.2631C14.25 23.0329 15.0833 23.5141 15.75 23.1292L24 18.366Z" fill="white" />
                                </svg>

                            </a>
                            <div class="arrow ">
                                <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.38557 1.22386C2.89539 0.723678 2.08997 0.723751 1.59988 1.22402L1.50696 1.31887C1.03081 1.80492 1.03087 2.58253 1.5071 3.0685L9.08105 10.7975C9.56251 11.2888 10.3505 11.2988 10.8442 10.8199L18.8338 3.06946C19.331 2.58711 19.3411 1.79237 18.8563 1.2975L18.7597 1.1989C18.28 0.709176 17.4953 0.69724 17.0009 1.17214L10.4968 7.41943C10.2002 7.70434 9.72948 7.69722 9.44162 7.40348L3.38557 1.22386Z" fill="#6C63FF" class="arcol" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="about ">
                        {{ $lesson->lesson->description }}
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
            @if(isset($show_disabled_modules))
            @foreach ($show_disabled_modules as $show_disabled_module)
            <div wire:key="{{ $show_disabled_module->id }}" class="module-lessons-title">
                <h3 class="module-name show-disabled">Модуль {{ $show_disabled_module->module_number }} (Недоступен)</h3>

                @php

                $show_disabled_modules_lessons = \App\Models\LessonModule::query()
                ->select('lessons.id', 'lessons.name',
                'lessons.description', 'lessons.task', 'lessons.lesson_number')
                ->join('lessons', 'lesson_modules.lesson_id', 'lessons.id')
                ->where('lesson_modules.module_id', '=', $show_disabled_module->id)
                ->get();

                @endphp

                @foreach($show_disabled_modules_lessons as $lesson)
                <div class="program-themes__item none">
                    <div class="program-themes__wrapper">
                        <div class="info">
                            <div class="circle none"></div>
                            <div class="name">{{ $lesson['lesson_number'] . '. ' . $lesson['name'] }}</div>
                        </div>
                        <div class="program-theme__end">
                            <div class="arrow none">
                                <svg width="20" height="12" viewBox="0 0 20 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3.38557 1.22386C2.89539 0.723678 2.08997 0.723751 1.59988 1.22402L1.50696 1.31887C1.03081 1.80492 1.03087 2.58253 1.5071 3.0685L9.08105 10.7975C9.56251 11.2888 10.3505 11.2988 10.8442 10.8199L18.8338 3.06946C19.331 2.58711 19.3411 1.79237 18.8563 1.2975L18.7597 1.1989C18.28 0.709176 17.4953 0.69724 17.0009 1.17214L10.4968 7.41943C10.2002 7.70434 9.72948 7.69722 9.44162 7.40348L3.38557 1.22386Z" fill="#6C63FF" class="arcol none" />
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="about ">
                        {{ $lesson['description'] }}
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
            @endif
        </div>
        @endif
    </div>
</div>