<!DOCTYPE html>
<html lang="ru">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

    <title>Сертификат</title>

    <style type="text/css">
        @font-face {
            font-family: 'Montserrat';
            src: url({{ storage_path("fonts/Montserrat-Regular.ttf") }}) format("truetype");
            font-weight: 400;
            font-style: normal;
        }
        @font-face {
            font-family: 'Montserrat';
            src: url({{ storage_path("fonts/Montserrat-Medium.ttf") }}) format("truetype");
            font-weight: 500;
            font-style: normal;
        }
        @font-face {
            font-family: 'Montserrat';
            src: url({{ storage_path("fonts/Montserrat-Bold.ttf") }}) format("truetype");
            font-weight: 700;
            font-style: normal;
        }
        @font-face {
            font-family: 'Montserrat';
            src: url({{ storage_path("fonts/Montserrat-SemiBold.ttf") }}) format("truetype");
            font-weight: 800;
            font-style: normal;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
        }
        p, h1, h2, h3 {
            margin: 0;
            padding: 0;
        }
        .certificate__main {
            margin-top: 95px;
        }
        .certificate__container {
            margin: auto;
            padding: 0 100px;
        }
        .certificate-title-subtitle {
            text-align: left;
        }
        .certificate__title {
            font-weight: 700;
            font-size: 156px;
            line-height: 130%;
            text-transform: uppercase;
            color: #6C63FF;
        }
        .certificate__subtitle {
            font-weight: 500;
            font-size: 64px;
            line-height: 130%;
            color: #1D1D39;
            margin-top: 0;
        }
        .certificate__line {
            height: 20px;
            width: 100%;
            background-color: #6C63FF;
            border-radius: 30px;
            margin-top: 85px;
        }
        .certificate-content__header {
            margin-top: 85px;
        }
        .certificate-content__text {
            font-weight: 500;
            font-size: 64px;
            line-height: 130%;
            color: #1D1D39;
        }
        .certificate-content__fio {
            font-weight: 700;
            font-size: 124px;
            line-height: 130%;
            color: #1D1D39;
            margin-top: 0;
        }
        .certificate-content__line {
            height: 20px;
            width: 200px;
            background-color: #FF22B0;
            border-radius: 30px;
            margin-top: 85px;
        }
        .certificate-content-footer {
            margin-top: 85px;
        }
        .certificate-content-footer__text {
            font-weight: 500;
            font-size: 64px;
            line-height: 130%;
            color: #1D1D39;
        }
        .certificate-content-footer__name {
            font-weight: 700;
            font-size: 124px;
            line-height: 130%;
            color: #6C63FF;
            margin-top: 0;
        }
        .certificate-footer {
            display: flex;
            height: 219px;
            margin-top: 50px;
        }
        .certificate-footer__item {
            margin-right: 200px;
        }
        .certificate-footer__date {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 64px;
            line-height: 150%;
            color: #1D1D39;
        }
        .certificate-footer__line {
            height: 12px;
            width: 500px;
            background-color: #1D1D39;
            border-radius: 30px;
            margin-top: 30px;
        }
        .certificate-footer__text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 500;
            font-size: 42px;
            line-height: 150%;
            color: #1D1D39;
            margin-top: 30px;
        }
        .footer-table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 60%;
        }
        .certificate__logos-table {
            width: 60%;
        }
        .footer-table td {
            height: 219px;
            vertical-align: bottom;
        }
        .certificate-footer__signature img {
            margin-left: 130px;
        }
    </style>

</head>

<body>

<div class="wrapper">
    <main class="main">
        <section class="certificate">
            <div class="certificate__container container">
                <header class="certificate__header">
                    <table class="certificate__logos-table">
                        <tr>
                            <td>
                                <div class="certificate__logo">
                                    <img src="{{ public_path('assets/img/logos/pautina.jpg') }}" alt="Путина - образовательная платформа">
                                </div>
                            </td>
                            <td>
                                <div class="certificate__logo">
                                    <img src="{{ public_path('assets/img/logos/mck-ktits.jpg') }}" alt="МЦК-КТИТС">
                                </div>
                            </td>
                            <td>
                                <div class="certificate__logo">
                                    <img src="{{ public_path('assets/img/logos/pautina-club.jpg') }}" alt="Путина - it-клуб">
                                </div>
                            </td>
                        </tr>
                    </table>
                </header>
                <main class="certificate__main">
                    <div class="certificate__title-subtitle certificate-title-subtitle">
                        <h1 class="certificate__title">Сертификат</h1>
                        <p class="certificate__subtitle"># {{ $data->id }}</p>
                    </div>
                    <div class="certificate__line"></div>
                    <div class="certificate__content certificate-content">
                        <div class="certificate-content__header">
                            <p class="certificate-content__text">Настоящим сертификат подтверждает, что</p>
                            <h2 class="certificate-content__fio">{{ $data->surname . ' ' . $data->name . ' ' . $data->patronymic }}</h2>
                        </div>
                        <div class="certificate-content__line"></div>
                        <div class="certificate-content__footer certificate-content-footer">
                            <p class="certificate-content-footer__text">Успешно завершил курс</p>
                            <h2 class="certificate-content-footer__name">{{ $data->course_name }}</h2>
                        </div>
                    </div>
                </main>
                <footer class="certificate__footer certificate-footer">
                    <table class="footer-table">
                        <tr>
                            <td>
                                <div class="certificate-footer__item">
                                    <p class="certificate-footer__date">{{ date('d.m.Y', strtotime($data->created_at)) }}</p>
                                    <div class="certificate-footer__line"></div>
                                    <div class="certificate-footer__text">Дата выпуска</div>
                                </div>
                            </td>
                            <td>
                                <div class="certificate-footer__item">
                                    <p class="certificate-footer__signature">
                                        <img src="{{ public_path('assets/img/signature/signature.png') }}" alt="Подпись">
                                    </p>
                                    <div class="certificate-footer__line"></div>
                                    <div class="certificate-footer__text">Зарипов Р.Р.</div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </footer>
            </div>
        </section>
    </main>
</div>

</body>

</html>
