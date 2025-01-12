<div class="content">
    <div class="title-two">
        <div class="text">
            <h1>Мои курсы</h1>
            <p>Список ваших курсов</p>
        </div>
        <div class="line"></div>
    </div>
    <div class="my-courses__nav">
        <div class="category-nav" x-data="{ active: 0 }">
            <a @click="active=0; $wire.all()" :class="active === 0 ? 'active' : ''">Все</a>
            <a @click="active=1; $wire.active()" :class="active === 1 ? 'active' : ''">Активные</a>
            <a @click="active=2; $wire.completed()" :class="active === 2 ? 'active' : ''">Завершенные</a>
        </div>
        <div class="courses">
            Всего курсов: {{ $applications ? $applications->count() : 0 }}
        </div>
    </div>
    <div class="my-courses__wrapper">
        @if($applications)
            @foreach($applications as $application)
            <div class="courses__item">
                <div class="one">
                    <div class="name">
                        <p>{{ $application->course->level->name }} курс</p>
                        <h2>{{ $application->course->name }}</h2>
                    </div>
                    <div class="play">
                        @if(isset($progressBarResult))
                        @foreach($progressBarResult as $result)
                        @if(isset($result['course_id']))
                        @if($result['course_id'] === $application->course_id)
                        <div class="progressBar">
                            <div class="line" style="height: {{ $result['result'] }}%"></div>
                        </div>
                        @endif
                        @endif
                        @endforeach
                        @endif
                        @php

                        // Создание экземпляра сервиса курса
                        $courseService = new \App\Services\Course\Service();
                        // Вычисление общего количества уроков курса
                        $allLessonsCount = $courseService->getAllCourseLessonsCount($application->course->id);

                        @endphp
                        <div class="continue">
                            <a href="{{ route('courses.more.subscribe', $application->course->id) }}" class="play-button">
                                <img src="{{ asset('assets/img/play.png') }}" alt="Изображение">
                            </a>
                            @if($courseService->checkIsPassedCertificateQuery($application->course->id, auth()->user()->id))
                            <div class="course-completed">
                                <div class="course-completed__icon">
                                    <svg width="35" height="36" viewBox="0 0 35 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="0.5" width="35" height="35" rx="17.5" fill="#51C853" />
                                        <path d="M16 22.9L12 18.9L13.4 17.5L16 20.1L22.6 13.5L24 14.9L16 22.9Z" fill="white" />
                                    </svg>
                                </div>
                                <p>Поздравляем! Вы успешно прошли курс.</p>
                            </div>
                            @else
                            <div class="text">
                                {{-- <p>Вы остановились на уроке</p> --}}
                                {{-- <div class="number-course">1. Введение в курс</div> --}}
                                <p>Завершите курс, чтобы получить сертификат</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="two">
                    <div class="lessons">
                        <div class="item">
                            <img src="{{ asset('assets/img/mini-play.svg') }}" alt="Изображение">
                            <p>{{ \App\Models\CourseUser::formatCount($allLessonsCount) }}</p>
                        </div>
                        @if($courseService->checkCertificateQuery($application->course->id, auth()->user()->id))
                        <div class="item certificate-page-link">
                            <div class="certificate-page-link__icon">
                                <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_573_4035)">
                                        <path d="M13.5996 0.0585938C10.6875 0.339844 7.79883 1.5293 5.53711 3.36914C4.86914 3.9082 3.81445 4.97461 3.28711 5.63672C1.94531 7.31836 0.84375 9.5918 0.386719 11.6309C0.0996094 12.9082 0.0351562 13.5352 0.0351562 15C0.0351562 16.4648 0.0996094 17.0918 0.386719 18.3691C0.849609 20.4492 1.98047 22.7578 3.36914 24.4629C3.9082 25.1309 4.97461 26.1855 5.63672 26.7129C7.31836 28.0547 9.5918 29.1562 11.6309 29.6133C12.9082 29.9004 13.5352 29.9648 15 29.9648C16.4648 29.9648 17.0918 29.9004 18.3691 29.6133C19.8984 29.2734 21.9023 28.418 23.2207 27.5449C25.5 26.0273 27.252 24.0352 28.4531 21.5918C29.1855 20.0977 29.6016 18.7559 29.8652 17.0508C30.0059 16.1074 30.0059 13.8926 29.8652 12.9492C29.6016 11.2441 29.1855 9.90234 28.4531 8.4082C27.668 6.81445 26.7949 5.5957 25.5352 4.35352C24.2988 3.12891 23.168 2.32617 21.5918 1.55273C20.1152 0.826172 18.7441 0.398438 17.1094 0.146484C16.3711 0.0351562 14.3672 -0.0117188 13.5996 0.0585938ZM17.0801 2.04492C18.4863 2.2793 19.5352 2.61914 20.8301 3.25195C24.1699 4.89258 26.7539 8.04492 27.6855 11.6367C28.002 12.8496 28.0898 13.5762 28.0898 15C28.0898 16.4238 28.002 17.1504 27.6855 18.3633C26.7539 21.9551 24.1699 25.1074 20.8301 26.748C19.5352 27.3809 18.5039 27.7148 17.0508 27.9609C15.9961 28.1426 14.0039 28.1426 12.9492 27.9609C11.4961 27.7148 10.4648 27.3809 9.16992 26.748C5.83008 25.1074 3.24609 21.9551 2.31445 18.3633C1.99805 17.1504 1.91016 16.4238 1.91016 15C1.91016 13.5762 1.99805 12.8496 2.31445 11.6367C2.63672 10.3945 3.31055 8.88281 4.01367 7.82227C6.25195 4.45898 9.70898 2.36133 13.7402 1.93359C14.4961 1.85156 16.2832 1.91016 17.0801 2.04492Z" fill="#6C63FF" />
                                        <path d="M14.6186 7.58203C14.4018 7.68164 14.2084 7.88672 14.1264 8.10351C14.0795 8.21484 14.062 9.88476 14.062 13.3184V18.3691L12.0581 16.3652C10.9506 15.2637 9.97211 14.332 9.88422 14.2969C9.11079 14.0098 8.36665 14.7891 8.69477 15.5449C8.80024 15.7852 14.2729 21.2461 14.4897 21.3281C14.7006 21.4043 15.2983 21.4043 15.5092 21.3281C15.6967 21.2578 21.1694 15.8203 21.3041 15.5742C21.351 15.4863 21.3862 15.3047 21.3862 15.1699C21.3862 14.502 20.6948 14.0508 20.0795 14.3203C19.9741 14.3672 19.0131 15.2812 17.9291 16.3711L15.9663 18.3398L15.937 13.2187C15.9077 8.15625 15.9077 8.0918 15.7846 7.93359C15.7202 7.8457 15.5971 7.7168 15.5151 7.6582C15.3159 7.51172 14.853 7.4707 14.6186 7.58203Z" fill="#6C63FF" />
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_573_4035">
                                            <rect width="30" height="30" fill="white" />
                                        </clipPath>
                                    </defs>
                                </svg>
                            </div>
                            <a class="certificate-page-link__text" href="{{ route('courses.gift', $application->course->id) }}">Страница сертификата</a>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('courses.more.subscribe', $application->course->id) }}" class="continue-training">
                        <p>Продолжить обучение</p>
                        <img src="{{ asset('assets/img/arrow2.png') }}" alt="Изображение">
                    </a>
                </div>
            </div>
            @endforeach
        @endif
    </div>
</div>