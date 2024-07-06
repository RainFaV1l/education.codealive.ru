<form class="review-modal__form modal__form" wire:submit.prevent="reviewStore()" method="post">
    @csrf

    @if($errors->any())
        <div class="errors">
            @foreach($errors->all() as $message)
                <p class="error">{{ $message }}</p>
            @endforeach
        </div>
    @endif

    <input wire:model="course_id" type="hidden" name="course_id" value="{{ $course->id }}">
    <div class="rating-area">
        <input wire:model="rating" type="radio" id="star-5" name="rating" value="5">
        <label for="star-5" title="Оценка «5»">
            <svg width="50" height="47" viewBox="0 0 50 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 1.61804L30.2496 17.7746L30.3618 18.1201H30.7251L47.7131 18.1201L33.9695 28.1054L33.6756 28.3189L33.7879 28.6644L39.0375 44.8209L25.2939 34.8356L25 34.6221L24.7061 34.8356L10.9625 44.8209L16.2121 28.6644L16.3244 28.3189L16.0305 28.1054L2.2869 18.1201L19.2749 18.1201H19.6382L19.7504 17.7746L25 1.61804Z" stroke="black" stroke-opacity="0.15"/>
            </svg>
        </label>
        <input wire:model="rating" type="radio" id="star-4" name="rating" value="4">
        <label for="star-4" title="Оценка «4»">
            <svg width="50" height="47" viewBox="0 0 50 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 1.61804L30.2496 17.7746L30.3618 18.1201H30.7251L47.7131 18.1201L33.9695 28.1054L33.6756 28.3189L33.7879 28.6644L39.0375 44.8209L25.2939 34.8356L25 34.6221L24.7061 34.8356L10.9625 44.8209L16.2121 28.6644L16.3244 28.3189L16.0305 28.1054L2.2869 18.1201L19.2749 18.1201H19.6382L19.7504 17.7746L25 1.61804Z" stroke="black" stroke-opacity="0.15"/>
            </svg>
        </label>
        <input wire:model="rating" type="radio" id="star-3" name="rating" value="3">
        <label for="star-3" title="Оценка «3»">
            <svg width="50" height="47" viewBox="0 0 50 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 1.61804L30.2496 17.7746L30.3618 18.1201H30.7251L47.7131 18.1201L33.9695 28.1054L33.6756 28.3189L33.7879 28.6644L39.0375 44.8209L25.2939 34.8356L25 34.6221L24.7061 34.8356L10.9625 44.8209L16.2121 28.6644L16.3244 28.3189L16.0305 28.1054L2.2869 18.1201L19.2749 18.1201H19.6382L19.7504 17.7746L25 1.61804Z" stroke="black" stroke-opacity="0.15"/>
            </svg>
        </label>
        <input wire:model="rating" type="radio" id="star-2" name="rating" value="2">
        <label for="star-2" title="Оценка «2»">
            <svg width="50" height="47" viewBox="0 0 50 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 1.61804L30.2496 17.7746L30.3618 18.1201H30.7251L47.7131 18.1201L33.9695 28.1054L33.6756 28.3189L33.7879 28.6644L39.0375 44.8209L25.2939 34.8356L25 34.6221L24.7061 34.8356L10.9625 44.8209L16.2121 28.6644L16.3244 28.3189L16.0305 28.1054L2.2869 18.1201L19.2749 18.1201H19.6382L19.7504 17.7746L25 1.61804Z" stroke="black" stroke-opacity="0.15"/>
            </svg>
        </label>
        <input wire:model="rating" type="radio" id="star-1" name="rating" value="1">
        <label for="star-1" title="Оценка «1»">
            <svg width="50" height="47" viewBox="0 0 50 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M25 1.61804L30.2496 17.7746L30.3618 18.1201H30.7251L47.7131 18.1201L33.9695 28.1054L33.6756 28.3189L33.7879 28.6644L39.0375 44.8209L25.2939 34.8356L25 34.6221L24.7061 34.8356L10.9625 44.8209L16.2121 28.6644L16.3244 28.3189L16.0305 28.1054L2.2869 18.1201L19.2749 18.1201H19.6382L19.7504 17.7746L25 1.61804Z" stroke="black" stroke-opacity="0.15"/>
            </svg>
        </label>
    </div>
    <textarea wire:model="description" name="description" class="modal-review__textarea modal__textarea" placeholder="Текст отзыва"></textarea>
    <input type="submit" class="review-modal__button modal__button" value="Отправить">
</form>
