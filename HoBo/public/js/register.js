class Register {
    constructor(){
        this.aboVak = document.getElementById('abonnentenVak');
        this.userVak = document.getElementById('userVak');
        this.persoonVak = document.getElementById('persoonVak');
        this.genrevak = document.getElementById('genrevak');
        this.registersubmit = document.getElementById('registersubmit');

        this.nextButton = document.getElementById('next');
        this.previeusButton = document.getElementById('previeus');

        this.sections = [this.userVak, this.persoonVak, this.genrevak, this.aboVak];
        this.currentSection = 0;

        window.addEventListener('load', () => {
            this.showSection(this.currentSection)
        });

        this.nextButton.addEventListener('click', () => {
            this.nextSection()
        })

        this.previeusButton.addEventListener('click', () => {
            this.previeusSection()
        })
    }

    showSection(index){
        this.sections.forEach(section => {
            section.style.display = 'none';
        });

        if (index >= 0 && index < this.sections.length) {
            this.sections[index].style.display = 'flex';
        }
    }

    nextSection(){
        if (this.currentSection < this.sections.length - 1) {
            this.currentSection++;
            this.showSection(this.currentSection);
        }
    }

    previeusSection(){
        if (this.currentSection > 0) {
            this.currentSection--;
            this.showSection(this.currentSection);
        }
    }
}


const register = new Register();