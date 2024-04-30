class Slider {
    constructor() {
        this.slider = document.querySelector('.carousel-images');
        this.images = document.querySelectorAll('.carousel-image');
        this.imageWidth = this.images[0].clientWidth;
        this.containerWidth = this.slider.clientWidth;
        this.index = 0;
        this.visibleImages = Math.ceil(this.containerWidth / (this.imageWidth + 30));
    }

    next() {
        if (this.index < this.images.length - 1) {
            this.index++;
            this.slide();
            this.images[this.index - 1].style.transition = "opacity 0.8s ease";
            this.images[this.index - 1].style.opacity = 0.5;  
        }
    }

    prev() {
        let adjust = this.index - 1;
    
        if (this.index > 0) {
            this.index--;
            this.slide();
            this.images[adjust].style.transition = "opacity 0.8s ease";
            this.images[adjust].style.opacity = 1;
        }
    }

    slide() {
        const offset = -this.index * (this.imageWidth + 30) * this.visibleImages;
        this.slider.style.transition = 'transform 2s ease-in-out';
        this.slider.style.transform = `translateX(${offset}px)`;
    }

    update() {
        this.imageWidth = this.images[0].clientWidth;
        this.visibleImages = Math.ceil(this.containerWidth / (this.imageWidth + 30));
    }
}

const slider = new Slider();

document.getElementById("next").addEventListener('click', () => slider.next());
document.getElementById("prev").addEventListener('click', () => slider.prev());
window.addEventListener("resize", () => slider.update());