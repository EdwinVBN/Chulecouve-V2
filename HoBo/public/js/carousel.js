class Slider {
    constructor(container) {
        this.container = container;
        this.slider = container.querySelector('.carousel-images');
        this.images = container.querySelectorAll('.carousel-image');
        this.imageWidth = this.images[0].clientWidth;
        this.containerWidth = this.slider.clientWidth;
        this.index = 0;
        this.visibleImages = Math.ceil(this.containerWidth / (this.imageWidth + 30));
        this.maxIndex = this.images.length - this.visibleImages;
        this.nextButton = container.querySelector('.next');
        this.prevButton = container.querySelector('.prev');
        this.bindEvents();
        this.updateButtons();
    }

    next() {
        if (!this.canSlide()) return;
        const nextIndex = this.index + this.visibleImages;
        this.index = nextIndex <= this.maxIndex ? nextIndex : this.maxIndex;
        this.slide();
    }

    prev() {
        if (!this.canSlide()) return;
        const prevIndex = this.index - this.visibleImages;
        this.index = prevIndex >= 0 ? prevIndex : 0;
        this.slide();
    }

    slide() {
        const offset = -this.index * (this.imageWidth + 30);
        this.slider.style.transition = 'transform 1s ease-in-out';
        this.slider.style.transform = `translateX(${offset}px)`;
        this.updateButtons();
    }

    update() {
        this.imageWidth = this.images[0].clientWidth;
        this.containerWidth = this.slider.clientWidth;
        this.visibleImages = Math.ceil(this.containerWidth / (this.imageWidth + 30));
        this.maxIndex = this.images.length - this.visibleImages;
        this.updateButtons();
    }

    updateButtons() {
        if (!this.canSlide()) {
            this.nextButton.disabled = true;
            this.prevButton.disabled = true;
        } else {
            this.nextButton.disabled = this.index >= this.maxIndex;
            this.prevButton.disabled = this.index <= 0;
        }
    }

    canSlide() {
        return this.images.length > this.visibleImages;
    }

    bindEvents() {
        this.nextButton.addEventListener('click', () => this.next());
        this.prevButton.addEventListener('click', () => this.prev());
        window.addEventListener("resize", () => this.update());
    }
}

document.querySelectorAll(".carousel").forEach(container => {
    new Slider(container);
});
