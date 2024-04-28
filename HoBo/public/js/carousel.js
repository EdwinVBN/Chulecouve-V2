class Slider {
    constructor() {
        this.slider = document.querySelector('.carousel-images');
        this.images = document.querySelectorAll('.carousel-image');
        this.containerWidth = this.slider.clientWidth;
        this.imageWidth = this.images[0].clientWidth;
        this.onScreen = Math.floor(this.containerWidth / this.imageWidth);
        this.index = 0;
    }

    next() {
        if (this.index < this.images.length - this.onScreen) {
            this.index++;
            this.slide();
        }
    }

    prev() {
        if (this.index > 0) {
            this.index--;
            this.slide();
        }
    }

    slide() {
        const offset = -this.index * this.containerWidth;
        this.slider.style.transform = `translateX(${offset}px)`;
    }

    updateWidth() {
        this.containerWidth = this.slider.clientWidth;
    }
}

const slider = new Slider();

document.getElementById("next").addEventListener('click', () => slider.next());
document.getElementById("prev").addEventListener('click', () => slider.prev());
window.addEventListener('resize', () => slider.updateWidth());