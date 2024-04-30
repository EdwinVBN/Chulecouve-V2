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
    }

    next() {
        const nextIndex = this.index + this.visibleImages;
        if (nextIndex <= this.maxIndex) {
            this.index = nextIndex;
            this.slide();
        } else {
            this.index = this.maxIndex;
            this.slide();
        }
    }

    prev() {
        const prevIndex = this.index - this.visibleImages;
        if (prevIndex >= 0) {
            this.index = prevIndex;
            this.slide();
        } else {
            this.index = 0;
            this.slide();
        }
    }

    slide() {
        const offset = -this.index * (this.imageWidth + 30);
        this.slider.style.transition = 'transform 1s ease-in-out';
        this.slider.style.transform = `translateX(${offset}px)`;
    }

    update() {
        this.imageWidth = this.images[0].clientWidth;
        this.containerWidth = this.slider.clientWidth;
        this.visibleImages = Math.ceil(this.containerWidth / (this.imageWidth + 30));
        this.maxIndex = this.images.length - this.visibleImages;
    }

    bindEvents() {
        this.nextButton.addEventListener('click', () => this.next());
        this.prevButton.addEventListener('click', () => this.prev());
        window.addEventListener("resize", () => this.update());
    }
}

document.querySelectorAll(".carousel").forEach(container => {
    const slider = new Slider(container);
});
