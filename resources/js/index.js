const burger = () => {

    const buttonOpen = document.querySelectorAll('.burger');
    if (!buttonOpen) return false;

    const parent = document.querySelector('.modal-burger');
    if (!parent) return false;
    const content = parent.querySelector('.content');
    if (!content) return false;
    const buttonClose = parent.querySelector('.close');
    if (!buttonClose) return false;

    const bg = document.querySelector('.bg-black');


    if (!bg) return false;

    buttonOpen.forEach(el => {
        el.addEventListener('click', (e) => {
            e.preventDefault();
            parent.classList.add('active');
            bg.classList.add('active');
            setTimeout(() => {
                content.classList.add('active')
            }, 0)
            document.body.style.overflow = "hidden"
        });
    });


    buttonClose.addEventListener('click', (e) => {
        e.preventDefault();
        content.classList.remove('active');
        setTimeout(() => {
            parent.classList.remove('active');
        }, 300);
        bg.classList.remove('active');

    });

    parent.addEventListener('click', (e) => {
        if (e.target == parent) {
            content.classList.remove('active');
            setTimeout(() => {
                parent.classList.remove('active');

            }, 300)
            bg.classList.remove('active');
        }
    });
};

const modal = ($openClass, $closeClass, $parentClass) => {

    const openButtons = document.querySelectorAll($openClass);
    if (!openButtons) return false;

    const parents = document.querySelectorAll($parentClass);
    if (!parents) return false;


    openButtons.forEach((openButton) => {
        openButton.addEventListener('click', (e) => {
            e.preventDefault();
            parents.forEach((parent) => {
                const closeButtons = parent.querySelectorAll($closeClass);
                if (!closeButtons) return false;
                // const yes = parent.querySelector('#delete');
                // yes.addEventListener('click', () => {
                //     // Получение дата-атрибута
                //     let id = openButton.dataset.deleteId;
                //     Livewire.emit('destroy', id);
                //     return false;
                // })
                parent.classList.add('active');
                closeButtons.forEach((closeButton) => {
                    closeButton.addEventListener('click', () => {
                        parent.classList.remove('active');
                    })
                });
                return false;
            })
        })
    })
};

const programCourse = () => {

    const parent = document.querySelectorAll('.program-themes__item');

    if (parent.length == 0) return false;

    parent.forEach(el => {

        const text = el.querySelector('.about');
        const circle = el.querySelector('.circle');
        const arrow = el.querySelector('.arrow');
        if (!arrow) return false;

        el.addEventListener('click', () => {

            el.classList.toggle('active');
            circle.classList.toggle('active');
            arrow.classList.toggle('active');
            text.classList.toggle('active');

        })

    })
}

const navAccount = () => {

    const parent = document.querySelector('.account');
    if (!parent) return false;

    const menu = parent.querySelector('.menu');
    const button = parent.querySelector('.name');
    const accountWrapper = parent.querySelector('.account-wrapper');
    const arrow = parent.querySelector('.arrow');

    accountWrapper.addEventListener('click', () => {
        button.style.cssText = `user-select: none;`;
        menu.classList.toggle('active');
        arrow.classList.toggle('active');
    })

}

const numberAnimation = (elems) => {

    let elements = elems;

    // Параметры анимации
    const time = 1000;
    const step = 1;

    function outNum(elements) {
        let e = document.querySelectorAll(elements);
        e.forEach((item) => {
            // Числа
            let number = +item.textContent;
            let n = 0;
            let t;
            if (number === 0) return;
            t = Math.round(time / (number / step));
            let interval = setInterval(() => {
                n = n + step;
                if (n === number) {
                    clearInterval(interval);
                }
                item.innerHTML = n;
            }, t);
        })
    }

    // Вызываем функцию
    outNum(elements);

}

// Изменение цвета текста option (при наведении opacity: 1)

const optionPlaceholder = (select) => {

    // Находим select
    const selectItems = document.querySelectorAll(select);

    // Проверяем существует ли данный select
    selectItems ? selectItems : false;

    // Перебор всех select
    selectItems.forEach((selectItem) => {

        // Вешаем событие change на select
        selectItem.addEventListener('change', () => {

            // Меняем цвет option при изменении значения option
            selectItem.style = 'color: #1D1D39 !important;';

        })
    })

}

const dragAndDrop = (dragableImg, dragTextItem, buttonItem, inputItem, dragIconItem, contentInfo) => {

    // Выбор всех необходимых элементов
    const dropArea = document.querySelectorAll(dragableImg);

    dropArea.forEach((dropArea) => {
        const dragText = dropArea.querySelector(dragTextItem);
        const button = dropArea.querySelector(buttonItem);
        const input = dropArea.querySelector(inputItem);
        const dragIcon = dropArea.querySelector(dragIconItem);
        const contentInfoItem = dropArea.querySelector(contentInfo);

        // Это глобальная переменная, и мы будем использовать ее внутри нескольких функций
        let file;

        // Если пользователь нажмет на кнопку, тогда ввод также нажмет
        button.addEventListener('click', () => {
            input.click();
        })


        input.addEventListener("change", (event) => {

            // Получение файла выбранного пользователем и [0] означает то, что если пользователь выберет несколько файлов, то мы выберем только первый
            file = event.target.files[0];
            dropArea.classList.add("active");

            // Вызываем функция
            showFile();

        });

        // Если пользователь перетаскивает файл поверх DropArea
        dropArea.addEventListener("dragover", (event) => {

            // Предотвращение поведения по умолчанию
            event.preventDefault();

            dropArea.classList.add("active");

            dragText.textContent = "Отпустите, чтобы загрузить файл";

        });

        // Если пользователь выведет за область перетаскиваемый файл из DropArea

        dropArea.addEventListener("dragleave", () => {

            dropArea.classList.remove("active");

            dragText.textContent = "Перетащите сюда баннер";

        });

        // Если пользователь сбросит файл на DropArea

        dropArea.addEventListener("drop", (event) => {

            // Предотвращение поведения по умолчанию
            event.preventDefault();

            // Получение файла выбора пользователя и [0] это означает, что если пользователь выберет несколько файлов, мы выберем только первый
            file = event.dataTransfer.file[0];

            // Вызов функции
            showFile();

        });

        function showFile() {

            // Получение выбранного типа файла
            let fileType = file.type;

            // Добавление некоторых допустимых расширений изображений в массив
            let validExtensions = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml', 'image/webp'];

            // Если выбранный пользователем файл является изображением
            if (validExtensions.includes(fileType)) {

                // создание нового объекта FileReader
                let fileReader = new FileReader();

                fileReader.addEventListener('load', () => {

                    // передача исходного файла пользователя в переменную fileURL
                    let fileURL = fileReader.result;

                    // создание тега img и передача выбранного пользователем источника файла внутри атрибута src
                    let imgTag = `<img class="drag-img-styles" src="${fileURL}" alt="image">`;

                    // добавление этого созданного тега img внутри контейнера dropArea
                    contentInfoItem.innerHTML = imgTag;
                    // dropArea.innerHTML = imgTag;

                });

                fileReader.readAsDataURL(file);

            } else {

                dragText.classList.add('active');
                dragIcon.classList.add('active');
                dropArea.classList.remove('active');
                dragText.textContent = "Неверный формат файла!";

            }
        }
    })

}

const dragAndDropMulti = (dragableImg, dragTextItem, buttonItem, inputItem, dragIconItem, contentInfoItem, contentFileItem, typeText) => {

    // Выбор всех необходимых элементов
    const dropArea = document.querySelectorAll(dragableImg);

    dropArea.forEach((dropArea) => {
        const dragText = dropArea.querySelector(dragTextItem);
        const button = dropArea.querySelector(buttonItem);
        const input = dropArea.querySelector(inputItem);
        const dragIcon = dropArea.querySelector(dragIconItem);
        const contentInfo = dropArea.querySelector(contentInfoItem);
        const contentFile = dropArea.querySelector(contentFileItem)

        // Это глобальная переменная, и мы будем использовать ее внутри нескольких функций
        let files;

        // Если пользователь нажмет на кнопку, тогда ввод также нажмет
        button.addEventListener('click', () => {
            input.click();
        })


        input.addEventListener("change", (event) => {

            // Получение файла выбранного пользователем и [0] означает то, что если пользователь выберет несколько файлов, то мы выберем только первый
            // file = event.target.files[0];

            files = event.target.files;

            dropArea.classList.add("active");

            // Вызываем функция
            showFile();

        });

        // Если пользователь перетаскивает файл поверх DropArea
        dropArea.addEventListener("dragover", (event) => {

            // Предотвращение поведения по умолчанию
            event.preventDefault();

            dropArea.classList.add("active");

            dragText.textContent = "Отпустите, чтобы загрузить файл";

        });

        // Если пользователь выведет за область перетаскиваемый файл из DropArea

        dropArea.addEventListener("dragleave", () => {

            dropArea.classList.remove("active");

            dragText.textContent = "Перетащите сюда баннер";

        });

        // Если пользователь сбросит файл на DropArea

        dropArea.addEventListener("drop", (event) => {

            // Предотвращение поведения по умолчанию
            event.preventDefault();

            // Получение файла выбора пользователя и [0] это означает, что если пользователь выберет несколько файлов, мы выберем только первый
            files = event.dataTransfer.files;

            // Вызов функции
            showFile();

        });

        function showFile() {
            if (files.length > 5) {
                dragText.classList.add('active');
                dragIcon.classList.add('active');
                dropArea.classList.remove('active');
                dragText.textContent = "Максимум 5 файлов!";
            } else {
                for (let file of files) {
                    // Получение выбранного типа файла
                    let fileType = file.type;
                    let validExtensions;

                    if (typeText == 'files') {
                        // Добавление некоторых допустимых расширений файлов в массив
                        validExtensions = ['image/jpeg', 'image/jpg', 'image/png', 'image/svg+xml',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/pdf',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'image/webp'
                        ];
                    } else if (typeText == 'videos') {
                        // Добавление некоторых допустимых расширений файлов в массив
                        validExtensions = ['video/ogg', 'video/mp4', 'video/webm'];
                    }

                    // Если выбранный пользователем файл является изображением
                    if (validExtensions.includes(fileType)) {

                        // создание нового объекта FileReader
                        let fileReader = new FileReader();

                        fileReader.addEventListener('load', () => {

                            // передача исходного файла пользователя в переменную fileURL
                            let fileURL = fileReader.result;

                            let image = document.createElement("img");
                            image.classList.add('drag-img-styles');
                            if (fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' ||
                                fileType === 'application/pdf' ||
                                fileType === 'application/doc' ||
                                fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                                image.src = '../../assets/img/document.svg';
                                image.alt = 'document';
                            } else {
                                image.src = fileURL;
                                image.alt = 'image';
                            }

                            contentInfo.innerHTML = "";

                            contentFile.appendChild(image);

                            // создание тега img и передача выбранного пользователем источника файла внутри атрибута src
                            // let imgTag = `<img class="drag-img-styles" src="${fileURL}" alt="image">`;

                            // добавление этого созданного тега img внутри контейнера dropArea
                            // contentInfo.innerHTML = imgTag;
                            // dropArea.innerHTML = imgTag;

                        });

                        fileReader.readAsDataURL(file);

                    } else {

                        dragText.classList.add('active');
                        dragIcon.classList.add('active');
                        dropArea.classList.remove('active');
                        dragText.textContent = "Неверный формат файла!";

                    }
                }
            }
        }
    })

}

// Маска для ввода телефона

const telMask = (telClass) => {

    const forEach = (list, callback) => {
        Array.prototype.forEach.call(list, callback);
    }

    forEach(document.querySelectorAll(telClass), (input) => {

        let keyCode;

        function mask(event) {
            event.keyCode && (keyCode = event.keyCode);
            let pos = this.selectionStart;
            if (pos < 3) event.preventDefault();
            let matrix = "+7 (___) ___ ____",
                i = 0,
                def = matrix.replace(/\D/g, ""),
                val = this.value.replace(/\D/g, ""),
                new_value = matrix.replace(/[_\d]/g, function (a) {
                    return i < val.length ? val.charAt(i++) || def.charAt(i) : a
                });
            i = new_value.indexOf("_");
            if (i != -1) {
                i < 5 && (i = 3);
                new_value = new_value.slice(0, i)
            }
            let reg = matrix.substr(0, this.value.length).replace(/_+/g,
                function (a) {
                    return "\\d{1," + a.length + "}"
                }).replace(/[+()]/g, "\\$&");
            reg = new RegExp("^" + reg + "$");
            if (!reg.test(this.value) || this.value.length < 5 || keyCode > 47 && keyCode < 58) this.value = new_value;
            if (event.type == "blur" && this.value.length < 5) this.value = ""
        }

        input.addEventListener("input", mask, false);
        input.addEventListener("focus", mask, false);
        input.addEventListener("blur", mask, false);
        input.addEventListener("keydown", mask, false)
    });
}

const elAnim = () => {

    // Изначально убираем opacity для работы с turbolinks

    // Отслеживаем перезагрузку сайта
    if (window.performance) {

        // Создаем функцию для автоматизации поиска классов
        const getList = (item) => {

            // Возвращаем анимацию
            let headersAnimation = document.querySelectorAll(item);

            headersAnimation.forEach((headerAnimation) => {

                headerAnimation.classList.add('none');

                // Добавление класса
                const onEntry = (entry) => {
                    entry.forEach(change => {
                        if (change.isIntersecting) {
                            change.target.classList.add('element-show');
                        } else {
                            // change.target.classList.remove('element-show');
                        }
                    });
                }

                // Создание класса для отслкживания изменений
                let options = { threshold: [0.5] };
                let observer = new IntersectionObserver(onEntry, options);
                let elements = document.querySelectorAll('.element-animation');

                // Отслкживание изменений
                elements.forEach(elm => {
                    observer.observe(elm);
                });

            })
        }

        getList('.header-animation');
        getList('.text-animation');
        getList('.opacity-anim');
        getList('.opacity-items-anim');
        getList('.img-anim');

    }

}

const smoothScroll = () => {

    SmoothScroll({
        // Время скролла 400 = 0.4 секунды
        animationTime: 800,
        // Размер шага в пикселях
        stepSize: 75,

        // Дополнительные настройки:

        // Ускорение
        accelerationDelta: 30,
        // Максимальное ускорение
        accelerationMax: 2,

        // Поддержка клавиатуры
        keyboardSupport: true,
        // Шаг скролла стрелками на клавиатуре в пикселях
        arrowScroll: 50,

        // Pulse (less tweakable)
        // ratio of "tail" to "acceleration"
        pulseAlgorithm: true,
        pulseScale: 4,
        pulseNormalize: 1,

        // Поддержка тачпада
        touchpadSupport: true,
    })

}

// Preloader

const preloader = () => {
    let preloader = document.getElementById('preloader');
    if (preloader) {
        let body = document.querySelector('body');
        body.classList.add('active');
        preloader.classList.add('active');
        window.addEventListener('load', () => {
            preloader.classList.remove('active');
            body.classList.remove('active');
        })
    }
}

const preloaderActive = () => {
    let preloader = document.getElementById('preloader');
    if (preloader) {
        let body = document.querySelector('body');
        body.classList.add('active');
        preloader.classList.add('active');
    }
}

// Плавный скролл до якоря

const anchorSmoothScroll = ($anchor) => {

    const parent = document.querySelectorAll($anchor);

    if (!parent) return false;

    const getElementHeight = (el) => {

        let value = document.querySelector(el).offsetHeight;

        return (!value) ? 0 : value

    }

    parent.forEach((link) => {

        link.addEventListener('click', function (e) {

            e.preventDefault();

            const href = this.getAttribute('href').substring(1);

            const scrollTarget = document.getElementById(href);

            const topOffset = getElementHeight('');

            const elementPosition = scrollTarget.getBoundingClientRect().top;

            const offsetPosition = elementPosition - topOffset;

            window.scrollBy({
                top: offsetPosition,
                behavior: 'smooth',
            });

        });

    });

}

const accordion = (accordion, parentItems, parentButton, parrentContent) => {

    const parent = document.querySelector(accordion);

    if (!parent) return false;

    const items = parent.querySelectorAll(parentItems);

    items.forEach((item) => {
        const open = item.querySelector(parentButton);
        const content = item.querySelector(parrentContent);
        open.addEventListener('click', () => {
            content.classList.toggle('active');
            open.classList.toggle('active');
            content.style.height = content.offsetHeight
        })
    })
}


const preViewImage = (openItem, outputItem, fileItem) => {
    let open = document.querySelector(openItem);
    if (!open) return false;
    open.addEventListener('click', () => {
        let file = document.querySelector(fileItem);
        file.addEventListener('change', (event) => {
            let output = document.querySelector(outputItem);
            output.src = URL.createObjectURL(event.target.files[0]);
            output.addEventListener('load', () => {
                URL.revokeObjectURL(output.src)
            })
        })
    })
}

const inputAdd = (addColumn, addInput, addColumnChild) => {

    const column = document.querySelector(addColumn);
    if (!column) return false;
    const input = column.querySelector(addInput);
    if (!input) return false;
    const addItemChildClass = column.querySelector(addColumnChild);
    if (!addItemChildClass) return false;

    if (!column || !input || !addItemChildClass) return false;

    let i = 1;

    const add = (column, addColumnChild) => {

        addColumnChild = addColumnChild.split('.').join('');

        // Генерируем элемент
        const element = document.createElement('div');
        element.classList = addColumnChild;
        element.innerHTML =
            `
                <input wire:model="video.`+ i + `" type="text" name="inputs[` + i + `][video_path]" class="add-course-form__input"
                       placeholder="Введите ссылку на видео">
                <button type="button" class="remove">Удалить</button>
            `
            ;
        column.appendChild(element);
    }

    input.addEventListener('click', () => {
        i++;
        add(column, addColumnChild);
    })

    document.addEventListener('DOMNodeInserted', () => {
        const items = column.querySelectorAll(addColumnChild);
        for (let item of items) {
            const removeInput = item.querySelector('.remove');
            if (!removeInput) {
                continue;
            }
            removeInput.addEventListener('click', () => {
                item.remove();
            })
        }
    })

}

const imageZoom = (lessonImageClass, fullSizeClass, closeClass) => {
    let isMapAdded = true;
    const images = document.querySelectorAll('.' + lessonImageClass);
    if (!images) return false;
    images.forEach((image) => {
        let fullSize = image.querySelector('.' + fullSizeClass);
        let fullSizeImage = document.createElement('img');
        image.addEventListener('click', (event) => {
            event.preventDefault();
            if (isMapAdded) {
                isMapAdded = false;
                let img = image.querySelector('img');
                fullSizeImage.src = img.src;
                fullSizeImage.className = 'zoom__image';
                fullSize.classList.add('active');
                fullSize.appendChild(fullSizeImage);
            } else {
                isMapAdded = true;
            }
        })
        let close = image.querySelector('.' + closeClass);
        close.addEventListener('click', () => {
            fullSize.classList.remove('active');
            fullSizeImage.remove();
        })
    })
}

// Parallax анимация для блока start
const parallax = () => {

    if (window.innerWidth <= 767) {
        return false;
    }

    const start = document.querySelector(".banner__img");

    if (!start) {
        return false;
    }

    const img = start.querySelector(".start-content-column-img");

    if (!img) return false;

    // Коэффициенты
    const forContent = 40;
    const forImg = 20;

    // Скорочть анимации
    const speed = 0.05;

    // Объявление переменных
    let positionX = 300,
        positionY = 0;
    let coordXprocent = 300,
        coordYprocent = 0;

    let setMouseParallaxStyle = () => {
        const distX = coordXprocent - positionX;
        const distY = coordYprocent - positionY;

        positionX = positionX + distX * speed;
        positionY = positionY + distY * speed;

        // Передаем стили
        img.style.cssText = `transform: translate(${positionX / forImg}%,${positionY / forImg
            }%);`;

        requestAnimationFrame(setMouseParallaxStyle);

        start.addEventListener("mousemove", (e) => {
            // Получение ширины и высоты блока
            const parallaxWidth = start.offsetWidth;
            const parallaxHeight = start.offsetHeight;

            // Ноль по середине
            const coordX = e.pageX - parallaxWidth / 2;
            const coordY = e.pageY - parallaxHeight / 2;

            // Получаем проценты
            coordXprocent = (coordX / parallaxWidth) * 100;
            coordYprocent = (coordY / parallaxHeight) * 100;
        });
    };

    setMouseParallaxStyle();
};

// Функция для показания пароля
const passwordShow = () => {

    const parents = document.querySelectorAll('.input-column');

    if (!parent) return false;

    parents.forEach((parent) => {

        let show = parent.querySelector('.show');
        let hide = parent.querySelector('.hide');
        let input = parent.querySelector('input[type=password]');

        if (!show || !hide) return false;

        let showFunc = () => {
            input.type = 'text';
            hide.classList.add('active');
        }

        let hideFunc = () => {
            input.type = 'password';
            hide.classList.remove('active');
        }

        show.addEventListener('click', () => {
            showFunc();
        })

        hide.addEventListener('click', () => {
            hideFunc();
        })

    })

}

// Функция для кнопки наверх
const up = () => {

    const upButtons = document.querySelectorAll('.up');

    if (!upButtons) return false;

    const scrollEvent = (upButton) => {
        window.addEventListener('scroll', () => {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                upButton.classList.add('show');
            } else {
                upButton.classList.remove('show');
            }
        })
    }

    upButtons.forEach((upButton) => {
        upButton.addEventListener('click', () => {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        })
        scrollEvent(upButton);
    });

}

// Функция для переключения темы и не только
const toggleTheme = (localStoragItemName, localStoragItemValue, elementClassName, buttonClassName) => {

    // Функция для добавления изменений на старницу
    let addChanges = () => {

        try {

            const element = document.querySelector(elementClassName);

            if (!element) return false;

            if (localStorage.getItem(localStoragItemName) === localStoragItemValue) {

                element.classList.add(localStoragItemValue);

            }

            else {

                element.classList.remove(localStoragItemValue);

            }

        }

        catch (error) {

            console.log(error);

        }

    }


    const button = document.querySelector(buttonClassName);

    if (!button) return false;

    button.addEventListener('click', (event) => {

        event.preventDefault();

        if (localStorage.getItem(localStoragItemName) === localStoragItemValue) {

            localStorage.removeItem(localStoragItemName);

        }

        else {

            localStorage.setItem(localStoragItemName, localStoragItemValue);

        }

        // Вызов функции для применения изменений
        addChanges();

    })

    // Вызов функции для применения изменений
    addChanges();

}

// Функция для движения текста по кругу
const circleText = (circleClass) => {

    const circle = document.querySelector(circleClass);

    if (!circle) return false;

    const text = 'Более' + ' ' + circle.dataset.count + ' ' + 'положительных отзывов!';

    circle.innerHTML = text.split('')
        .map((e, i) => `<span style="--rot:${i * 12}deg">${e}</span>`).join('');

}


// Надо писать turbo:load
function turboAll() {

    // Масштабирование изображения
    imageZoom('lesson-image', 'full-size', 'close');

    // Меню аккаунта
    navAccount();

    // Плавный скролл
    smoothScroll();

    // Анимация цифр в админ панели
    numberAnimation('.admin-panel-content-info-item__title');

    // Маска для ввода телефона
    telMask('.tel');

    // Бургер меню
    burger();

    // Аккордион для programCourse
    programCourse();

    // Аккордион
    accordion('.accordion__list', '.accordion__item', '.accordion__button', '.accordion__content', '.add-course-form-img__img');

    // Смена цвета placeholder для option
    optionPlaceholder('.add-course-form__select');

    // Показ изображения автарки
    preViewImage('.ava-img-label', '.ava-img', '.ava-input-file');

    // dragAndDrop для файлов
    dragAndDrop('.dragable-img', '.add-course-form-img-content-name__text', '.drag-img', '.add-course-form-img__img', '.add-course-form-img-content__svg', '.add-course-form-img-content__name');
    dragAndDropMulti('.dragable-img-multi', '.add-course-form-img-content-name__text', '.drag-img', '.add-course-form-img__img', '.add-course-form-img-content__svg', '.add-course-form-img-content__name', '.add-course-form-img-content__files', 'files');
    dragAndDropMulti('.dragable-img-multi-videos', '.add-course-form-img-content-name__text', '.drag-img', '.add-course-form-img__img', '.add-course-form-img-content__svg', '.add-course-form-img-content__name', '.add-course-form-img-content__files', 'videos');

    // Добавление input полей
    inputAdd('.add-video-column', '.add-video-paths', '.video__input-column');

    Livewire.onPageExpired((response, message) => { })

    // Отображение модальных окон
    modal('.guest-subscribe-course-modal-button', '.modal__close', '.guest-course-subscribe-modal');
    modal('.subscribe-course-error-modal-button', '.modal__close', '.course-subscribe-error-modal');
    modal('.delete-modal-open', '.modal__close', '.delete-modal');

    // Parallax эффект
    parallax();

    // Функция для показа пароля
    passwordShow();

    // Функция для кнопки наверх
    up();

    // preloaderActive();

    // Перезагружаем плавную анимацию при переходе на страницу авторизации
    elAnim();

    // Функция для переключения темы и не только
    toggleTheme('betaMessage', 'show', '.beta-message', '.beta-message__close');

    // Функция для движения текста вокруг круга
    circleText('.banner-cicrle .circle');

    // Прослушивание события livewire notification
    window.addEventListener('notification', (e) => {

        const notificationFunc = () => {

            // Находим элемент уведомления
            const notificationItem = document.querySelector('#livewire-notification');

            if (!notificationItem) return false;

            notificationItem.style.pointerEvents = "visible";
            notificationItem.style.opacity = 1;
            notificationItem.style.zIndex = 11;

            const notificationText = notificationItem.querySelector('.notification__text');

            if (!notificationText) return false;

            notificationText.textContent = e.detail.text

            const notification__icon = notificationItem.querySelector('.notification__icon');

            if (!notification__icon) return false;

            let svg = notificationItem.querySelector('.notification-icon-text__row svg');

            if (svg) {
                let parent = svg.parentNode;
                if (!parent) return false;
                parent.removeChild(svg);
            }

            let icon = '';
            let str = '';
            let parser = new DOMParser();

            switch (e.detail.type) {
                case "success":
                    str = `<svg width="40" height="41" viewBox="0 0 40 41" fill="none" xmlns="http://www.w3.org/2000/svg"><rect y="0.5" width="40" height="40" rx="20" fill="#43C065"/> <rect x="7" y="7.5" width="26" height="25.4" rx="12.7" fill="white"/> <path d="M18.7071 24.1929C18.3166 24.5834 17.6834 24.5834 17.2929 24.1929L14.7 21.6C14.3134 21.2134 14.3134 20.5866 14.7 20.2V20.2C15.0866 19.8134 15.7134 19.8134 16.1 20.2L17.2929 21.3929C17.6834 21.7834 18.3166 21.7834 18.7071 21.3929L23.9 16.2C24.2866 15.8134 24.9134 15.8134 25.3 16.2V16.2C25.6866 16.5866 25.6866 17.2134 25.3 17.6L18.7071 24.1929Z" fill="#43C065"/></svg>`;
                    icon = parser.parseFromString(str, 'application/xml');
                    break;
                case "info":
                    str = `<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#6C63FF"/><rect x="7" y="7" width="26" height="25.4" rx="12.7" fill="white" /><path d="M20 17.7C19.7348 17.7 19.4804 17.8054 19.2929 17.9929C19.1054 18.1804 19 18.4348 19 18.7V24.7C19 24.9652 19.1054 25.2196 19.2929 25.4071C19.4804 25.5947 19.7348 25.7 20 25.7C20.2652 25.7 20.5196 25.5947 20.7071 25.4071C20.8946 25.2196 21 24.9652 21 24.7V18.7C21 18.4348 20.8946 18.1804 20.7071 17.9929C20.5196 17.8054 20.2652 17.7 20 17.7ZM20 13.7C19.7528 13.7 19.5111 13.7733 19.3055 13.9107C19.1 14.048 18.9398 14.2433 18.8452 14.4717C18.7505 14.7001 18.7258 14.9514 18.774 15.1939C18.8223 15.4364 18.9413 15.6591 19.1161 15.8339C19.2909 16.0087 19.5137 16.1278 19.7561 16.176C19.9986 16.2242 20.2499 16.1995 20.4784 16.1049C20.7068 16.0103 20.902 15.85 21.0393 15.6445C21.1767 15.4389 21.25 15.1972 21.25 14.95C21.25 14.6185 21.1183 14.3005 20.8839 14.0661C20.6495 13.8317 20.3315 13.7 20 13.7Z" fill="#6C63FF"/></svg>`;
                    icon = parser.parseFromString(str, 'application/xml');
                    break;
                case "error":
                    str = `<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="40" height="40" rx="20" fill="#F32434" /><path d="M23.1111 11.7921L30.5567 24.1933C31.6267 25.9744 31.1012 28.3178 29.3823 29.4267C28.8054 29.8002 28.1329 29.9993 27.4456 30H12.5533C10.5299 30 8.88879 28.3 8.88879 26.2011C8.88879 25.4911 9.08102 24.7966 9.44213 24.1933L16.8889 11.7921C17.9578 10.011 20.2178 9.46539 21.9367 10.5743C22.4122 10.881 22.8145 11.2976 23.1111 11.7921ZM20 25.5555C20.2947 25.5555 20.5773 25.4385 20.7857 25.2301C20.994 25.0217 21.1111 24.7391 21.1111 24.4444C21.1111 24.1497 20.994 23.8671 20.7857 23.6587C20.5773 23.4503 20.2947 23.3333 20 23.3333C19.7053 23.3333 19.4227 23.4503 19.2143 23.6587C19.0059 23.8671 18.8889 24.1497 18.8889 24.4444C18.8889 24.7391 19.0059 25.0217 19.2143 25.2301C19.4227 25.4385 19.7053 25.5555 20 25.5555ZM20 15.5554C19.7053 15.5554 19.4227 15.6725 19.2143 15.8809C19.0059 16.0893 18.8889 16.3719 18.8889 16.6666V21.111C18.8889 21.4057 19.0059 21.6883 19.2143 21.8967C19.4227 22.1051 19.7053 22.2222 20 22.2222C20.2947 22.2222 20.5773 22.1051 20.7857 21.8967C20.994 21.6883 21.1111 21.4057 21.1111 21.111V16.6666C21.1111 16.3719 20.994 16.0893 20.7857 15.8809C20.5773 15.6725 20.2947 15.5554 20 15.5554Z" fill="white"/></svg>`;
                    icon = parser.parseFromString(str, 'application/xml');
                    break;
                case "warning":
                    str = `<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width = "40" height = "40" rx = "20" fill = "#FCD425" /><path d="M23.1111 11.7921L30.5567 24.1933C31.6267 25.9744 31.1012 28.3178 29.3823 29.4267C28.8054 29.8002 28.1329 29.9993 27.4456 30H12.5533C10.5299 30 8.88879 28.3 8.88879 26.2011C8.88879 25.4911 9.08102 24.7966 9.44213 24.1933L16.8889 11.7921C17.9578 10.011 20.2178 9.46539 21.9367 10.5743C22.4122 10.881 22.8145 11.2976 23.1111 11.7921ZM20 25.5555C20.2947 25.5555 20.5773 25.4385 20.7857 25.2301C20.994 25.0217 21.1111 24.7391 21.1111 24.4444C21.1111 24.1497 20.994 23.8671 20.7857 23.6587C20.5773 23.4503 20.2947 23.3333 20 23.3333C19.7053 23.3333 19.4227 23.4503 19.2143 23.6587C19.0059 23.8671 18.8889 24.1497 18.8889 24.4444C18.8889 24.7391 19.0059 25.0217 19.2143 25.2301C19.4227 25.4385 19.7053 25.5555 20 25.5555ZM20 15.5554C19.7053 15.5554 19.4227 15.6725 19.2143 15.8809C19.0059 16.0893 18.8889 16.3719 18.8889 16.6666V21.111C18.8889 21.4057 19.0059 21.6883 19.2143 21.8967C19.4227 22.1051 19.7053 22.2222 20 22.2222C20.2947 22.2222 20.5773 22.1051 20.7857 21.8967C20.994 21.6883 21.1111 21.4057 21.1111 21.111V16.6666C21.1111 16.3719 20.994 16.0893 20.7857 15.8809C20.5773 15.6725 20.2947 15.5554 20 15.5554Z" fill="white"/></svg>`;
                    icon = parser.parseFromString(str, 'application/xml');
                    break;
            }

            notification__icon.append(notification__icon.ownerDocument.importNode(icon.documentElement, true));

            const close = notificationItem.querySelector('.notification__close');
            if (!close) return false;

            close.addEventListener("click", () => {
                notificationItem.style.pointerEvents = "none";
                notificationItem.style.opacity = 0;
                notificationItem.style.zIndex = -1;
                let svg = notificationItem.querySelector('.notification-icon-text__row svg');
                if (!svg) return false;
                let parent = svg.parentNode;
                if (!parent) return false;
                setTimeout(() => {
                    parent.removeChild(svg);
                }, 2000);
            })
        }

        setTimeout(notificationFunc, 250);

    })

}

document.addEventListener("turbo:load", function () {
    turboAll();
});


const init = () => {
    elAnim();
    preloader();
    // Устанавливаем дефолтное значение
    localStorage.setItem('betaMessage', 'show');
}

document.addEventListener('DOMContentLoaded', init);
